<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Database\Seeders\PermissionValue;
use Database\Seeders\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrderController extends BaseController
{
    // TODO Annotation pour utiliser la fonction auth() de AuthController pour chaque page
    public function viewOrders(Request $request, ?string $alertMsg = null): View|Response|RedirectResponse|Redirector
    {

        // TODO réduire le nombre de requêtes et voir à propos du cache (je pense qu'on ne fera pas de cache mais on opti les requêtes)
        // TODO factoriser avec un déctorateur le code pour l'utilisateur et si possible factoriser l'envoi des variables courantes (ex: $suerPermissions)
        /* @var User $user */
        $user = Auth::user();
        $userRoles = $user->getRoles(); // Récupération des rôles en base de données
        $userPermissions = Role::getPermissionsAsDict($userRoles); // Récupération d'un dictionnaire des permissions pour simplifier la vérification de permissions

        $userDepartments = $userRoles->filter(fn (Role $role) => $role->isDepartment()); // Filtre des rôles qui sont des départements

        // Récupération uniquement des commandes dont l'utilisateur a accès
        $orders =
            $userPermissions[PermissionValue::ADMIN->value] || $userPermissions[PermissionValue::CONSULTER_TOUTES_COMMANDES->value]
                ? Order::paginate(20)
                : Order::where(function (Builder $query) use ($userDepartments, $userPermissions) {
                    $userDepartments->each(function (Role $department) use ($query, $userPermissions) {
                        if ($userPermissions[PermissionValue::CONSULTER_COMMANDES_DEPARTMENT->value]) {
                            $query->orWhere('department_id', $department->getId());
                        }
                    });
                })
                    ->paginate(20);

        $suppliers = Supplier::all(['id', 'company_name', 'is_valid']); // Récupération uniquement des informations utiles à propos des fournisseurs

        // TODO flash messages: redirect('urls.create')->with('success', 'URL has been added'); - j'ai pas compris comment ça marche
        if (! $alertMsg) {
            $alertMsg = "Connecté en tant que {$user->getFullName()} avec les rôles {$userRoles->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}";
        }

        $openPurchaseOrderModal = $request['openPurchaseOrderModal'];

        return view('orders', [
            'user' => $user,
            'orders' => $orders,
            'validSupplierNames' => $suppliers->where('is_valid', true)->map(fn (Supplier $supplier) => $supplier->getCompanyName())->values()->toArray(),
            'alertMessage' => $alertMsg,
            'userPermissions' => $userPermissions,
            'userRoles' => $userRoles,
            'userDepartments' => $userDepartments,
            'openPurchaseOrderModal' => $openPurchaseOrderModal,
        ]);
    }

    public function newOrder(): View
    {
        return view('newOrder');
    }

    public function submitNewOrder(Request $request): View
    {

        // TODO valider les données
        // TODO utiliser les setters pour mettre en base

        return $this->viewOrders($request);
    }

    public function serviceFinancier(Request $request): View
    {
        $user = Auth::user();
        $orders = Order::all();

        return view('service_financier', [
            'orders' => $orders,
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$user->getRoles()->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}",
        ]);

    }

    public function changeState(Request $request, $id)
    {
        /* @var Order $order */
        $order = Order::findOrFail($id);

        // On met à jour la colonne "status"
        // $order->states = $request->states;
        $order->setStatus($request['status']);

        // Plus besoin de save de setter
        // $order->save();

        return $this->viewOrders($request, 'Statut de la commande '.$order->getOrderNumber().' changé avec succès ! ');

    }

    public function actionUploadPurchaseOrder(Request $request)
    {
        $id = $request['id'];

        /* @var Order $order */
        $order = Order::findOrFail($id);

        $nextStep = $request['nextStep'];
        $isSigned = $request['signed'];

        // Stockage du fichier dans storage/app/public/quotes
        $success = $order->uploadPurchaseOrder($request, $isSigned, false);
        if (! $success) {
            $request['openPurchaseOrderModal'] = true;
            return back()->withErrors("Une erreur est survenue à l'enregistrement du bon de commande");
        }

        if ($nextStep) {
            $order->setStatus($isSigned ? Status::BON_DE_COMMANDE_SIGNE : Status::BON_DE_COMMANDE_NON_SIGNE);
        }

        $order->save();

        return $this->viewOrders($request, 'Le bon de commande a été ajouté avec succès.');
    }
}
