<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class AboutController extends Controller
{
    /**
     * Affiche la page À Propos.
     */
    public function about(Request $request): View
    {
        // On garde la logique de session pour que l'utilisateur reste connecté
        // si la barre de navigation en a besoin pour afficher son nom.
        if (! app()->isLocal()) {
            if (!session()->has('user')) {
                session()->put('user', User::where('login', $request->server('REMOTE_USER'))->first());
            }
        }

        // On retourne simplement la vue
        return view('about');
    }
}