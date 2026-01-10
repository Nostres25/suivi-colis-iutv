<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colis;

class ColisController extends Controller
{
    public function rechercher(Request $request)
    {
        $mot = $request->input('mot'); // ce que l'utilisateur tape

        $colis = Colis::where('id_colis', $mot)
            ->orWhere('label', 'LIKE', '%' . $mot . '%')
            ->first();

        return view('colis.recherche', compact('colis', 'mot'));
    }
}
