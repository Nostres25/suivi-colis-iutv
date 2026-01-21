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
use Illuminate\Routing\Controller;
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
        $userRoles = $user->getRoles(); // Récupération des rôles en base de données
        $userPermissions = Role::getPermissionsAsDict($userRoles); // Récupération d'un dictionnaire des permissions pour simplifier la vérification de permissions

        $userDepartments = $userRoles->filter(fn (Role $role) => $role->isDepartment()); // Filtre des rôles qui sont des départements

        // Récupération uniquement des commandes dont l'utilisateur a accès
        $orders =
            $orders = Order::paginate(20);
        

        $suppliers = Supplier::all(['id', 'company_name', 'is_valid']); // Récupération uniquement des informations utiles à propos des fournisseurs

        // TODO flash messages: redirect('urls.create')->with('success', 'URL has been added');
        return view('orders', [
            'user' => $user,
            'orders' => $orders,
            'validSupplierNames' => $suppliers->where('is_valid', true)->map(fn (Supplier $supplier) => $supplier->getCompanyName())->values()->toArray(),
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$userRoles->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}",
            'userPermissions' => $userPermissions,
            'userRoles' => $userRoles,
            'userDepartments' => $userDepartments,
        ]);
    }

    public function newOrder(): View
    {
        return view('newOrder');
    }

    public function submitNewOrder(Request $request): RedirectResponse
    {
        // TODO Do something to save the new order by the post form
        // Send a flash message
       
    // 1) VALIDATION
      // 1️⃣ VALIDATION
    $validated = $request->validate([
        'title'         => 'required|string|max:255',
        'supplier_id'   => 'required|exists:suppliers,id',
        'order_num'     => 'required|string|max:255',
        'quote_num'     => 'required|string|max:255',
        'department_id' => 'required|exists:roles,id',
        'description'   => 'nullable|string',
        'status'        => 'required|string',
        'cost'          => 'nullable|numeric',
        'path_quote'    => 'nullable|file|mimes:pdf|max:20480',
    ]);

    // 2️⃣ CRÉATION DE LA COMMANDE
    $order = new Order();

    // 3️⃣ ATTRIBUTION DES CHAMPS
    $order->title         = $validated['title'];
    $order->order_num     = $validated['order_num'];
    $order->quote_num     = $validated['quote_num'];
    $order->description   = $validated['description'] ?? null;
    $order->status        = $validated['status'];
    $order->cost          = $validated['cost'] ?? null;
    $order->supplier_id   = $validated['supplier_id'];
    $order->department_id = $validated['department_id'];
    $order->author_id     = Auth::id();

    // 4️⃣ UPLOAD DU DEVIS
    if ($request->hasFile('path_quote')) {
        $order->path_quote = $request->file('path_quote')
            ->store('quotes', 'public');
    }

    // 5️⃣ SAUVEGARDE
    $order->save();

    // 6️⃣ REDIRECTION
    return redirect()
        ->route('orders.index')
        ->with('success', "Commande '{$order->title}' créée avec succès !");
}
}