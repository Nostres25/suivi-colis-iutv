<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    function auth() {
        if (config('app.env') == 'production') {
        $app_url = config('app.url');
        return redirect("https://cas.univ-spn.fr/cas/login?service={$app_url}");
    } else {
        return redirect(config('app.url'));
    }
    // Should be a bit different with more informaitions about CAS
    // In example, to go on the "ENT", the  CAS look like this : https://cas.univ-spn.fr/cas/login?service=https%3A%2F%2Fetd.univ-spn.fr%2F
    }
}
