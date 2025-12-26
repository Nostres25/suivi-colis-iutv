<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    // TODO Annotation pour utiliser la fonction auth() de AuthController pour chaque page
    public function viewOrders(Request $request): View
    {

        if ($request->method() === 'POST') {
            session()->put('user', User::find($request->input('user')));
        }

        $order = new \App\Models\Commande;
        $order->num_commande = '4500161828';
        $order->label = 'Cablage salle blanche';
        $order->description = 'Cablage electrique de la salle blanche du CRIT';
        $order->id_fournisseur = 1;
        $order->num_devis = 'd2509123';
        $order->etat = 'BROUILLON';

        $order->save();

        return $order;

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

    public function submitNewOrder(): View
    {
        // TODO Do something to save the new order by the post form
        // Send a flash message

        return $this->viewOrders();
    }
}
