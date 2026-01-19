<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupplierController extends BaseController
{
    public function viewSuppliers(Request $request): View|Response|RedirectResponse|Redirector
    {
        $user = Auth::user();
        $userRoles = $user->getRoles();
        $userPermissions = Role::getPermissionsAsDict($userRoles);

        $search = $request->input('search');
        
        if ($search) {
            $suppliers = Supplier::where('company_name', 'LIKE', "%{$search}%")
                ->orWhere('contact_name', 'LIKE', "%{$search}%")
                ->orWhere('siret', 'LIKE', "%{$search}%")
                ->paginate(10);
        } else {
            $suppliers = Supplier::paginate(10);
        }

        return view('suppliers', [
            'suppliers' => $suppliers,
            'userPermissions' => $userPermissions,
            '$userRoles' => $userRoles,
            'search' => $search,
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$userRoles->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}",
        ]);
    }
}