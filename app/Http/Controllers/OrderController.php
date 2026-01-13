<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Database\Seeders\PermissionValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrderController extends Controller
{
    // TODO Annotation pour utiliser la fonction auth() de AuthController pour chaque page
    public function viewOrders(Request $request): View|\Illuminate\Http\JsonResponse|Response
    {

        // Connexion de l'utilisateur
        if (! app()->isLocal()) {
            // M.Butelle a dit que l'information NOM Prénom était récupérable à l'aide de $_SERVER['HTTP_CAS_DISPLAYNAME'] et le login à l'aide de $_SERVER['REMOTE_USER']
            // Voir si $request->server('REMOTE_USER') fonctionne
            session()->put('user', User::where('login', $request->server('REMOTE_USER'))->first());

        } else {

            // En local, on utilise un utilisateur de test
            session()->put(
                'user',
                User::all()->first(
                    function (User $user) {
                        $roles = $user->getRoles();

                        // Rôle que l'utilisateur de test doit avoir (mettre null pour pas de rôle en particulier)
                        // Choix du rôle de l'utilisateur : Service financier, Directeur IUT, Département Info, Département SD, Département RT
                        $roleToHave = 'Directeur IUT';

                        // Nombre de rôles que l'utilisateur de test doit avoir
                        $roleNumber = 2;

                        return (is_null($roleToHave) || $roles->first((fn (Role $role) => $role->getName() == $roleToHave))) && $roles->count() == $roleNumber;

                    }
                )
            );

        }

        // TODO réduire le nombre de requêtes et voir à propos du cache (je pense qu'on ne fera pas de cache mais on opti les requêtes)

        /* @var User $user */
        $user = session('user');
        if (is_null($user)) {
            $response_content =
                "
                <h1> Erreur 401 : Unauthorized</h1><br/>
                Votre compte utilisateur n'a pas été trouvé, vous n'avez donc pas la permission d'accéder au site.<br/>
                Il s'agit très probablement d'une erreur, merci de contacter le responsable de ce site de suivi des colis à l'IUT de Villetaneuse et de sa base de données.
                ";

            if (app()->isLocal()) {
                $response_content .=
                    "
                    <br/><br/><strong>Si vous êtes en local</strong>, pour tester le site par exemple, la raison est qu'aucun des utilisateurs en base de données ne respecte les conditions de l'utilisateur de test.<br/>
                    Pour régler cela :<br/>
                    - mettez des conditions qui correspondent à au moins un utilisateur dans la base de données<br/><br/>
                    - générez de nouvelles données de test additionnelles avec la commande <code>php artisan db:seed</code> une ou plusieurs fois afin d'espérer générer l'utilisateur qui correspond à ces conditions (Il se peut que les tables de la base de données n'aient pas été créées ou qu'elles aient été modifiées, ce qui provoquerait une erreur. Ainsi, exécutez <code>php artisan migrate --seed</code> pour créer tables de la base de données et les remplir de données de test)<br/><br/>
                    - créez vous-même l'utilisateur en base de données, en lui attribuant un rôle via la table pivot (ou table association) <code>role_user</code> (accédez à la base de données à l'aide de la commande <code>php artisan db</code>. Si le site est correctement installé, cela fonctionnera)<br/><br/>
                    - ajoutez dans le fichier <code>database/seeders/LocalTestSeeder.php</code> une condition pour toujours garantir d'avoir un utilisateur respectant les conditions souhaitées dans les données de test <br/><br/>

                    Si vous venez d'installer le projet, assurez-vous de bien suivre toutes les instructions de l'installation au préalable !
                    ";
            }

            return response($response_content, 401);
        }
        $userRoles = $user->getRoles(); // Récupération des rôles en base de données
        $userPermissions = Role::getPermissionsAsDict($userRoles); // Récupération d'un dictionnaire des permissions pour simplifier la vérification de permissions

        $userDepartments = $userRoles->filter(fn (Role $role) => $role->isDepartment()); // Filtre des rôles qui sont des départements

        // Récupération uniquement des commandes dont l'utilisateur a accès
        $orders =
            $userPermissions[PermissionValue::ADMIN->value] || $userPermissions[PermissionValue::CONSULTER_TOUTES_COMMANDES->value]
                ? Order::paginate(20)
                : Order::where(function (Builder $query) use ($userDepartments, $userPermissions) {
                    $userDepartments->each(function (Role $department) use ($query, $userPermissions) {
                        if ($userPermissions[PermissionValue::CONSULTER_COMMANDES_DEPARTMENT->value]) {
                            $query->orWhere('department_id', $department->getId());
                        }
                    });
                })
                    ->paginate(20);

        $suppliers = Supplier::all(['id', 'company_name', 'is_valid']); // Récupération uniquement des informations utiles à propos des fournisseurs

        // TODO flash messages: redirect('urls.create')->with('success', 'URL has been added');
        return view('orders', [
            'user' => $user,
            'orders' => $orders,
            'validSupplierNames' => $suppliers->where('is_valid', true)->map(fn (Supplier $supplier) => $supplier->getCompanyName())->values()->toArray(),
            'alertMessage' => "Connecté en tant que {$user->getFullName()} avec les rôles {$userRoles->map(fn (Role $role) => $role->getName())->toJson(JSON_UNESCAPED_UNICODE)}",
            'userPermissions' => $userPermissions,
            'userRoles' => $userRoles,
            'userDepartments' => $userDepartments,
        ]);
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
