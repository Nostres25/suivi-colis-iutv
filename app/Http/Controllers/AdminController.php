<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\BaseController;

class AdminController extends BaseController {
    
    /**
     * Cette méthode délegue l'authentification de l'utilisateur à la méthode
     * auth() de BaseController, puis redirige vers /admin si l'authentification
     * est réussie. Sinon, elle retourne un message d'erreur.
     * @param Request $request La requête HTTP entrante.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response une redirection vers /admin
     * ou un message d'erreur
     */
   
    public function login(Request $request) {
    //On lance l'authentification (CAS ou Local)
    $result = $this->auth($request);

    
    if ($result['success'] === true) {
        
        // On récupère l'utilisateur qui vient d'être connecté
        $user = Auth::user();

        $isDbAdmin = $user->roles->contains(function ($role) {
            return (method_exists($role, 'getName') ? $role->getName() : $role->name) === 'Administrateur BD';
        });

        if ($isDbAdmin) {
            return redirect('/admin');
        }
        return response("<h1>Erreur 403 : Accès Refusé</h1><p>Vous êtes bien connecté en tant que <b>{$user->first_name} {$user->last_name}</b>, mais vous n'avez pas le rôle 'Administrateur BD' requis pour accéder à cette zone.</p>", 403);
    }

    
    return $result['response'];
}
    


}


