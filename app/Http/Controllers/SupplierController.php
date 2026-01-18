<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Database\Seeders\PermissionValue;
use Illuminate\Http\RedirectResponse;
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

        // 1. Initialisation de la Query
        $query = Supplier::query();

        // ---------------------------------------------------------
        // ETAPE 1 : TRI PAR VALIDITÉ (Reste identique)
        // ---------------------------------------------------------
        $isFinancier = $user->hasPermission(PermissionValue::GERER_FOURNISSEURS);

        if ($isFinancier) {
            // Service Financier : Non validés en premier
            $query->orderBy('is_valid', 'asc');
        } else {
            // Autres : Validés en premier
            $query->orderBy('is_valid', 'desc');
        }

        // ---------------------------------------------------------
        // ETAPE 2 : LE TRI "MÉLANGÉ" (Activité Globale)
        // ---------------------------------------------------------

        // Nous allons trier en utilisant une logique SQL brute (orderByRaw).
        // La logique est : PRENDS LA PLUS GRANDE DATE ENTRE :
        // 1. La date de modification du fournisseur (suppliers.updated_at)
        // 2. La date de modification de sa dernière commande (sous-requête)

        // NOTE : COALESCE est là pour gérer le cas où un fournisseur n'a AUCUNE commande.
        // Dans ce cas, la sous-requête renvoie NULL, et on se rabat sur suppliers.updated_at.

        $sqlActivitySort = '
    GREATEST(
        suppliers.updated_at,
        COALESCE(
            (SELECT updated_at FROM orders WHERE supplier_id = suppliers.id ORDER BY updated_at DESC LIMIT 1),
            suppliers.updated_at
        )
    ) DESC
';

        $query->orderByRaw($sqlActivitySort);

        // ---------------------------------------------------------
        // ETAPE 3 : Pagination
        // ---------------------------------------------------------
        $suppliers = $query->paginate(10);

        return view('suppliers', [
            'user' => $user,
            'suppliers' => $suppliers,
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$user->getRoles()->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}",
        ]);
    }
}
