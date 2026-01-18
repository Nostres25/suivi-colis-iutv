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
    public function viewSuppliers(): View|Response|RedirectResponse|Redirector
    {
        /* @var User $user */
        $user = Auth::user();

        // TODO trier les fournisseurs les plus récents / actifs(date des dernières commandes) et prioriser les demandes en attente pour la personne qui a demandé l'ajout
        $suppliers = Supplier::paginate(10); // Récupération uniquement des informations utiles à propos des fournisseurs

        return view('suppliers', [
            'user' => $user,
            'suppliers' => $suppliers,
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$user->getRoles()->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}",
        ]);
    }
}
