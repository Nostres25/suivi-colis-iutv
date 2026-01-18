<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Database\Seeders\PermissionValue;
use Database\Seeders\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrderController extends BaseController
{
    // TODO Annotation pour utiliser la fonction auth() de AuthController pour chaque page
    public function viewOrders(?string $alertMsg = null): View|Response|RedirectResponse|Redirector
    {
        $request = request();

        // TODO réduire le nombre de requêtes et voir à propos du cache (je pense qu'on ne fera pas de cache mais on opti les requêtes)
        // TODO factoriser avec un déctorateur le code pour l'utilisateur et si possible factoriser l'envoi des variables courantes (ex: $suerPermissions)
        /* @var User $user */
        $user = Auth::user();
        $userRoles = $user->getRoles(); // Récupération des rôles en base de données
        $userPermissions = $user->getPermissions(); // Récupération d'un dictionnaire des permissions pour simplifier la vérification de permissions

        $userDepartments = $userRoles->filter(fn (Role $role) => $role->isDepartment()); // Filtre des rôles qui sont des départements

        // Récupération uniquement des commandes dont l'utilisateur a accès
        /* @var Paginator $orders */
        $orders =
            $user->hasPermission(PermissionValue::CONSULTER_TOUTES_COMMANDES)
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

        //        /* @var Package $package */
        //        $package = Package::where('id', 241)->first();

        return view('orders', [
            'user' => $user,
            'orders' => $orders,
            'validSupplierNames' => $suppliers->where('is_valid', true)->map(fn (Supplier $supplier) => $supplier->getCompanyName())->values()->toArray(),
            'userDepartments' => $userDepartments,
        ]);
    }

    public function submitNewOrder(Request $request): View
    {

        // TODO valider les données
        // TODO utiliser les setters pour mettre en base

        return $this->viewOrders($request);
    }

    public function actionUploadPurchaseOrder($page = 1)
    {

        $request = request();
        $id = $request['id'];

        /* @var Order $order */
        $order = Order::findOrFail($id);

        $nextStep = $request['nextStep'];
        $isSigned = $request['signed'];

        // Stockage du fichier dans storage/app/public/quotes
        // TODO ce serait bien que upload purchase order retourne le validator pour avoir l'erreur personnalisée
        $success = $order->uploadPurchaseOrder($request, $isSigned, false);
        if (! $success) {
            session()->flash('purchaseOrderError-'.$id, "Une erreur est survenue à l'enregistrement du bon de commande");

            return $this->modalUploadPurchaseOrder($id);
        }

        if ($nextStep) {
            $order->setStatus($isSigned ? Status::BON_DE_COMMANDE_SIGNE : Status::BON_DE_COMMANDE_NON_SIGNE, false);
        }


        $sucessToSave = $order->save();
        if (! $sucessToSave) {
            session()->flash('purchaseOrderError-'.$id, 'Une erreur est survenue à la sauvegarde de la commande !');

            return $this->modalUploadPurchaseOrder($id);
        }

        // Fallback pour fonctionnement sans JS (si besoin)
        return BaseController::getSuccessModal('Le bon de commande a été ajouté avec succès à la commande N°'.$order->getOrderNumber().'.');
    }

    public function modalUploadPurchaseOrder($id)
    {

        /* @var Order $order */
        $sign = request()['sign'];
        $order = Order::where('id', $id)->first();

        $user = Auth::user();

        // On retourne une vue partielle (sans header, footer, etc.)
        // render() est important si vous voulez manipuler le string,
        // mais return view() suffit souvent car Laravel le convertit en string.
        return view('components.addPurchaseOrderModal', [
            'user' => Auth::user(),
            'order' => $order,
            'orderId' => $order->getId(),
            'canSign' => $sign || $user->hasPermission(PermissionValue::SIGNER_BONS_DE_COMMANDES),
        ]);
    }

    public function modalRefuseToSign($id) {}

    public function modalRefuse($id) {
        $request = request();
        $about = $request['about'];

    }

    public function modalPaid($id) {}

    public function modalUploadDeliveryNote($id) {

    }

    public function modalSentToSupplier($id) {

    }

    public function modalDeliveredPackage($id) {

    }

    public function modalDeliveredAll(string $id)
    {

    }

    public function modalViewDetails(string $id)
    {

    }

    public function sendAutoMail(Request $request)
    {
        // TODO code pour envoyer un mail automatique
    }
}
