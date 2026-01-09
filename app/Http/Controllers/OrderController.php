<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Database\Seeders\PermissionValue;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    // TODO Annotation pour utiliser la fonction auth() de AuthController pour chaque page
    public function viewOrders(Request $request): View
    {

        // Connexion de l'utilisateur
        if (! app()->isLocal()) {
            // M.Butelle a dit que l'information NOM Prénom était récupérable à l'aide de $_SERVER['HTTP_CAS_DISPLAYNAME'] et le login à l'aide de $_SERVER['REMOTE_USER']
            // Voir si $request->server('REMOTE_USER') fonctionne
            session()->put('user', User::where('login', $request->server('REMOTE_USER'))->first());

        } else {

            // En local, on utilise un utilisateur de test
            session()->put(
                'user',
                User::all()->first(
                    fn (User $user) => $user->getRoles()->first(fn (Role $role) => $role->getName() === 'Département Info')
                )
            );

        }

        /* @var User $user */
        $user = session('user');

        // TODO réduire le nombre de requêtes et voir à propos du cache
        // TODO Filtrer les commandes visibles en fonction du rôle
        // TODO faire un scroll infini
        // TODO Chercher plusieurs permissions en une boucle

        /* @var User $user */
        $user = session('user');
        $userRoles = $user->getRoles();

        $userPermissions = Role::getPermissionsAsDict($userRoles);

        $orders = Order::all();

        if (! $userPermissions[PermissionValue::ADMIN->value]) {
            $orders
                ->filter(function (Order $order) use ($userRoles, $userPermissions) {
                    $department = $order->getDepartment();
                    $sameDepartment = $userRoles->contains($department);

                    return
                        ($sameDepartment && $userPermissions[PermissionValue::CONSULTER_COMMANDES_DEPARTMENT->value])
                        || $userPermissions[PermissionValue::CONSULTER_TOUTES_COMMANDES->value];
                });
        }

        $suppliers = Supplier::all(['id', 'company_name', 'is_valid']);

        // TODO flash messages: redirect('urls.create')->with('success', 'URL has been added');
        return view('orders', [
            'user' => $user,
            'orders' => $orders,
            'validSupplierNames' => $suppliers->where('is_valid', true)->map(fn (Supplier $supplier) => $supplier->getCompanyName())->values()->toArray(),
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$userRoles->map(fn (Role $role) => $role->getName())}",
            'userPermissions' => $userPermissions,
            'userRoles' => $userRoles,
            'userDepartment' => $userRoles->filter(fn (Role $role) => $role->isDepartment()),
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
