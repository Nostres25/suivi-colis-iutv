<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // /**
	//  * Make the CAS authentification request and
	//  * redirect the user to the login page.
	//  *
	//  * @return RedirectResponse
	//  */
	// public function CASRequest(): RedirectResponse {
	// 	return CAS::request(
	// 		$this->getCasReturnRoute()
	// 	) ;
	// }

	// /**
	//  * Manage the user return.
	//  *
	//  * @return RedirectResponse
	//  */
	// public function CASResponse(): RedirectResponse {
	// 	$data = CAS::response(
	// 		$this->getCasReturnRoute()
	// 	) ;

	// 	$login = $data['login'] ; // or username ?

	// 	// Do something with the login
	// }

	// /**
	//  * Get the CAS return route.
	//  *
	//  * @return string
	//  */
	// private function getCasReturnRoute(): string {
	// 	return route('/') ;
	// }
}
