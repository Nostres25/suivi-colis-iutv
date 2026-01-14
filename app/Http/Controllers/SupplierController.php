<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupplierController extends BaseController
{
    public function viewSuppliers(Request $request): View|Response|RedirectResponse|Redirector
    {
        // TODO réduire le nombre de requêtes et voir à propos du cache (je pense qu'on ne fera pas de cache mais on opti les requêtes)

        /* @var User $user */
        $user = Auth::user();
        $userRoles = $user->getRoles(); // Récupération des rôles en base de données
        $userPermissions = Role::getPermissionsAsDict($userRoles); // Récupération d'un dictionnaire des permissions pour simplifier la vérification de permissions

        // TODO trier les fournisseurs les plus récents / actifs(date des dernières commandes) et prioriser les demandes en attente pour la personne qui a demandé l'ajout
        $suppliers = Supplier::paginate(10); // Récupération uniquement des informations utiles à propos des fournisseurs

        return view('suppliers', [
            'suppliers' => $suppliers,
            'userPermissions' => $userPermissions,
            '$userRoles' => $userRoles,
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$userRoles->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}",
        ]);
    }
}
