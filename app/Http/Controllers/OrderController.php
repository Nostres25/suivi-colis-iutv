<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Database\Seeders\PermissionValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends BaseController
{
    // TODO Annotation pour utiliser la fonction auth() de AuthController pour chaque page
    public function viewOrders(Request $request): View|Response|RedirectResponse|Redirector
    {
        // TODO réduire le nombre de requêtes et voir à propos du cache (je pense qu'on ne fera pas de cache mais on opti les requêtes)
        // TODO factoriser avec un déctorateur le code pour l'utilisateur et si possible factoriser l'envoi des variables courantes (ex: $suerPermissions)
        /* @var User $user */
        $user = Auth::user();
        $userRoles = $user->getRoles();
        $userPermissions = Role::getPermissionsAsDict($userRoles);
        $userDepartments = $userRoles->filter(fn (Role $role) => $role->isDepartment());

        // --- LOGIQUE DE RECHERCHE ---
        $search = $request->input('search');
        $query = Order::query();

        // Récupération uniquement des commandes dont l'utilisateur a accès
        if (! ($userPermissions[PermissionValue::ADMIN->value] || $userPermissions[PermissionValue::CONSULTER_TOUTES_COMMANDES->value])) {
            $query->where(function (Builder $q) use ($userDepartments, $userPermissions) {
                $userDepartments->each(function (Role $department) use ($q, $userPermissions) {
                    if ($userPermissions[PermissionValue::CONSULTER_COMMANDES_DEPARTMENT->value]) {
                        $q->orWhere('department_id', $department->getId());
                    }
                });
            });
        }

        // 2. Filtre de recherche (si rempli)
        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('order_num', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();
        // ----------------------------

        $suppliers = Supplier::all(['id', 'company_name', 'is_valid']);

        return view('orders', [
            'user' => $user,
            'orders' => $orders,
            'validSupplierNames' => $suppliers->where('is_valid', true)->map(fn (Supplier $supplier) => $supplier->getCompanyName())->values()->toArray(),
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$userRoles->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}",
            'userPermissions' => $userPermissions,
            'userRoles' => $userRoles,
            'userDepartments' => $userDepartments,
            'search' => $search, // Variable pour la vue
        ]);
    }

    public function newOrder(): View
    {
        return view('newOrder');
    }

    public function submitNewOrder(Request $request): View
    {
        // TODO Do something to save the new order by the post form
        // Send a flash message
        return $this->viewOrders($request);
    }
}
