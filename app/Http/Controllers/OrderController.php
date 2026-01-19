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
        $userId = $user->getId();
        // Initialisation de la requête
        $query = Order::query();
        if (!$user->hasPermission(PermissionValue::CONSULTER_TOUTES_COMMANDES)) {
            $query->where(function (Builder $q) use ($userDepartments, $userPermissions) {
                $userDepartments->each(function (Role $department) use ($q, $userPermissions) {
                    if ($userPermissions[PermissionValue::CONSULTER_COMMANDES_DEPARTMENT->value]) {
                        $q->orWhere('department_id', $department->getId());
                    }
                });
            });
        }

        // --- 2. TRI INTELLIGENT AVEC ENUMS ---

        // Définition des rôles
        $isDirecteur = $user->hasPermission(PermissionValue::SIGNER_BONS_DE_COMMANDES);
        $isFinancier = $user->hasPermission(PermissionValue::GERER_PAIEMENT_FOURNISSEURS);
        // On identifie le responsable colis par son ID de rôle (2) car ses permissions sont assez génériques
        $isResponsableColis = $userRoles->contains('id', 2);
        $isDepartement = $userDepartments->isNotEmpty();

        if ($isDirecteur) {
            // TRI DIRECTEUR
            $bcNonSigne = Status::BON_DE_COMMANDE_NON_SIGNE->value;
            $devis = Status::DEVIS->value;

            $query->orderByRaw("CASE
            WHEN status = '$bcNonSigne' THEN 1
            WHEN status = '$devis' THEN 2
            ELSE 3
        END");

        } elseif ($isFinancier) {
            // TRI FINANCIER
            $p1 = Status::SERVICE_FAIT->value;
            $p2 = Status::DEVIS->value;
            $p3 = Status::BON_DE_COMMANDE_NON_SIGNE->value;
            $p4 = Status::BON_DE_COMMANDE_REFUSE->value;
            $p5 = Status::LIVRE_ET_PAYE->value;

            $query->orderByRaw("CASE
            WHEN status = '$p1' THEN 1
            WHEN status = '$p2' THEN 2
            WHEN status = '$p3' THEN 3
            WHEN status = '$p4' THEN 4
            WHEN status = '$p5' THEN 5
            ELSE 6
        END");

        } elseif ($isResponsableColis) {
            // TRI RESPONSABLE COLIS
            // 1. En attente de livraison (Réponse reçue ou Partiel)
            // 2. Commande envoyée (Potentiellement en attente)
            // 3. Le reste

            $p1_Colis = implode("','", [
                Status::COMMANDE_AVEC_REPONSE->value,
                Status::PARTIELLEMENT_LIVRE->value
            ]);

            $p2_Colis = Status::COMMANDE->value;

            $query->orderByRaw("CASE
            WHEN status IN ('$p1_Colis') THEN 1
            WHEN status = '$p2_Colis' THEN 2
            ELSE 3
        END");

        } elseif ($isDepartement) {
            // TRI DEPARTEMENTS
            $brouillon = Status::BROUILLON->value;

            $refusals = implode("','", [
                Status::DEVIS_REFUSE->value,
                Status::BON_DE_COMMANDE_REFUSE->value,
                Status::COMMANDE_REFUSEE->value
            ]);

            $actionsRequises = implode("','", [
                Status::BON_DE_COMMANDE_SIGNE->value,
                Status::COMMANDE->value,
                Status::COMMANDE_AVEC_REPONSE->value,
                Status::PARTIELLEMENT_LIVRE->value
            ]);

            $sqlSort = "CASE
            WHEN status = '$brouillon' AND author_id = ? THEN 1
            WHEN status IN ('$refusals') THEN 2
            WHEN status IN ('$actionsRequises') THEN 3
            ELSE 4
        END";

            $query->orderByRaw($sqlSort, [$user->getId()]);
        }

        // --- 3. TRI SECONDAIRE (Date) ---
        // Les plus anciennes (date lointaine) en premier
        $query->orderBy('updated_at', 'asc');


        // --- 4. EXECUTION ---
        $orders = $query->paginate(20);

        //        /* @var Paginator $orders */
        //        $orders =
        //            $user->hasPermission(PermissionValue::CONSULTER_TOUTES_COMMANDES)
        //                ? Order::paginate(20)
        //                : Order::where(function (Builder $query) use ($userDepartments, $userPermissions) {
        //                    $userDepartments->each(function (Role $department) use ($query, $userPermissions) {
        //                        if ($userPermissions[PermissionValue::CONSULTER_COMMANDES_DEPARTMENT->value]) {
        //                            $query->orWhere('department_id', $department->getId());
        //                        }
        //                    });
        //                })
        //                    ->paginate(20);
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

    public function modalRefuse($id)
    {
        $request = request();
        $about = $request['about'];

    }

    public function modalPaid($id) {}

    public function modalUploadDeliveryNote($id) {}

    public function modalSentToSupplier($id) {}

    public function modalDeliveredPackage($id) {}

    public function modalDeliveredAll(string $id) {}

    public function modalViewDetails(string $id) {}

    public function sendAutoMail(Request $request)
    {
        // TODO code pour envoyer un mail automatique
    }
}
