<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CASController extends Controller
{
    public function casLogin()
    {
        // Apache a déjà authentifié l'utilisateur
        if (!isset($_SERVER['REMOTE_USER'])) {
            abort(403, 'Utilisateur non authentifié par CAS');
        }

        $login = $_SERVER['REMOTE_USER'];
        $displayName = $_SERVER['HTTP_CAS_DISPLAYNAME'] ?? null;

        $prenom = null;
        $nom = null;

        if ($displayName) {
            [$prenom, $nom] = explode(' ', $displayName, 2);
        }

        // Création ou récupération de l'utilisateur
        $user = User::firstOrCreate(
            ['login' => $login],
            [
                'prenom' => $prenom,
                'nom' => $nom,
                'email' => $login . '@univ.fr'
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}