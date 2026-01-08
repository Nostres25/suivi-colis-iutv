<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
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
            session()->put('user', User::all()->first());

        }

        /* @var User $user */
        $user = session('user');

        $supplier = Supplier::all()->first();

        if (is_null($supplier)) {
            $supplier = new Supplier(
                [
                    'company_name' => 'S.C.I.E Câblage',
                    'siret' => '37865039400042',
                    'email' => 'info@scie.fr',
                    'phone_number' => '0148923756',
                    'contact_name' => 'Geoffrey Delacourt',
                    'note' => 'Fournisseur sérieux, respectant les délais annoncés. À ne pas facher avec des délais de paiement trop élevés',
                    'is_valid' => true,
                ]);

        }

        $supplier->save();

        // $order = new \App\Models\Order;
        // $order->order_num = '4500161828'; // présent dans le nom du fichier du bon de commande et devis, et dans le bon de commande lui-même
        // $order->label = 'Cablage salle blanche'; // désignation de la commande dans bon de commande et nom du projet dans devis (différents)
        // $order->description = 'Cablage electrique de la salle blanche du CRIT';
        // $order->supplier_id = 1;
        // $order->quote_num = 'd2509123';
        // $order->states = 'BROUILLON';
        // $order->

        // $order->save();

        // TODO réduire le nombre de requêtes et voir à propos du cache
        // TODO Filtrer les commandes visibles en fonction du rôle
        // TODO faire un scroll infini
        $orders = Order::all();
        //            ->map(function (Order $order) {
        //            return [
        //                'order_num' => $order->getOrderNumber(),
        //                'title' => $order->getTitle(),
        //                'department' => $order->getDepartment(),
        //                'author' => $order->getAuthor(),
        //                'status' => $order->getStatus(),
        //                'createdAt' => $order->getCreationDate(),
        //                'updatedAt' => $order->getLastUpdateDate(),
        //            ];
        //        });

        $suppliers = Supplier::all(['id', 'company_name', 'is_valid']);

        //TODO flash messages: redirect('urls.create')->with('success', 'URL has been added');
        return view('orders', [
            'orders' => $orders,
            'validSupplierNames' => $suppliers->where('is_valid', true)->map(fn (Supplier $supplier) => $supplier->getCompanyName())->values()->toArray(),
            'suppliers' => $suppliers,
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$user->getRoles()->map(fn (Role $role) => $role->getName())}",
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
