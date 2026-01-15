<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DirectorController extends BaseController
{
    public function dashboard(Request $request): View
    {
        $user = Auth::user();
        $userRoles = $user->getRoles();
        $userPermissions = Role::getPermissionsAsDict($userRoles);
        
        // Correction : 'status' au lieu de 'states' + Valeur ENUM correcte
        $ordersAwaitingSignature = Order::where('status', 'BON_DE_COMMANDE_NON_SIGNE')->get();
        
        // Historique des commandes traitées (Valeurs ENUM de votre base)
        $orderHistory = Order::whereIn('status', ['BON_DE_COMMANDE_SIGNE', 'BON_DE_COMMANDE_REFUSE', 'COMMANDE', 'LIVRE_ET_PAYE', 'ANNULE'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
        
        return view('director', [
            'user' => $user,
            'ordersAwaitingSignature' => $ordersAwaitingSignature,
            'orderHistory' => $orderHistory,
            'userPermissions' => $userPermissions,
            'userRoles' => $userRoles,
        ]);
    }

    public function signOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $order->status = 'BON_DE_COMMANDE_SIGNE';
        $order->save();
        
        return redirect()->back()->with('success', 'Bon de commande signé avec succès');
    }

    public function refuseOrder(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);
        
        $order = Order::findOrFail($id);
        
        $order->status = 'BON_DE_COMMANDE_REFUSE';
        $order->refusal_reason = $request->reason;
        $order->save();
        
        return redirect()->back()->with('success', 'Bon de commande refusé');
    }
}