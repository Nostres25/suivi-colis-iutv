<?php

namespace App\Http\Controllers;

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
            // session()->put('user', User::where('role', 'Administrateur BD')->first());

        }
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
        $orders = [
            [
                'id' => '1',
                'department' => 'CRIT',
                'author' => 'Franck BUTELLE',
                'title' => 'Cablage salle blanche',
                'state' => 'En attente d’un bon de commande',
                'stateChangedAt' => '06/11/2025 à 12:33',
                'createdAt' => '01/11/2025 à 00:01',
            ],
            [
                'id' => '2',
                'department' => 'R&T',
                'author' => 'John DOE',
                'title' => 'Rasbery PI',
                'state' => 'Commande en attente de livraison',
                'stateChangedAt' => 'Depuis le 25/10/2025 à 14:12',
                'createdAt' => '01/11/2025 à 00:01',
            ],
            [
                'id' => '3',
                'department' => 'R&T',
                'author' => 'John DOE',
                'title' => 'Rasbery PI',
                'state' => 'Commande en attente de livraison',
                'stateChangedAt' => 'Depuis le 25/10/2025 à 14:12',
                'createdAt' => '01/11/2025 à 00:01',
            ],
        ];

        return view('orders', ['orders' => $orders]);
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
