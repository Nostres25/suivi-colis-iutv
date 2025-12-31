<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Log;
use App\Models\Order;
use App\Models\Package;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalTestSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $nbSuppliers = 10;
        $nbUsers = 20;
        $nbOrders = 50;

        // Génération de fournisseurs aléatoires
        $suppliers = Supplier::factory($nbSuppliers)->create();

        // Génération d'utilisateurs aléatoires
        $users = User::factory($nbUsers)->create();
        $users->each(function (User $user) {
            // Chaque utilisateur doit avoir au moins un rôle aléatoire
            $roles = [
                Role::all()->random(),
            ];

            // et dans 10% des cas un utilisateur a UN AUTRE, aussi aléatoire
            $role2 = Role::all()->random();
            $hasSecondRole = rand(0, 100) <= 10 && $roles[0] !== $role2;
            if ($hasSecondRole) {
                $roles[] = $role2;
            }

            // Sauvegarder les associations rôles-utilisateur en base de données pour l'utilisateur actuel (dans la table association)
            $user->roles()->sync($roles);
        });

        // Génération de commandes aléatoires
        $orders = Order::factory($nbOrders)
            ->create()
            ->each(function (Order $order) use ($users) {

                // Pour chaque commande créer 1 à 5 colis
                Package::factory(rand(1, 5))
                    ->make()
                    ->each(function (Package $package) use ($order) {
                        $package->order()->associate($order);
                        $package->save();
                    });

                // Pour chaque commande créer entre 1 et 5 log (action)
                Log::factory(rand(1, 5))
                    ->make()
                    ->each(function (Log $log) use ($order, $users) {
                        $log->order_id = $order->id;
                        $log->author_id = $users->random()->id;
                        $log->save();
                    });

                // Pour chaque commande, faire écrire des commentaires à tous les utilisateurs qui ont accès à la commande
                foreach ($users as $user) {

                    // Pour cela, vérification si l'utilisateur a un rôle en commun avec l'auteur de la commande (actuellement l'auteur du premier log / première actionà
                    $roles_order_author = $order->logs->first()->author->roles;
                    $write_comment = false;

                    foreach ($user->roles as $role1) {
                        // Si l'utilisateur a la permission administrateur, il a accès à la commande donc il écrit un commentaire
                        // OU si un rôle en commun a été trouvé et que la boucle imbriquée a été sautée, sauter aussi cette boucle
                        if ($write_comment || $role1->hasPermission(Permission::ADMIN)) {
                            $write_comment = true;
                            break;
                        }

                        // Vérification des rôles en commun
                        foreach ($roles_order_author as $role2) {
                            if ($role1->is($role2)) {
                                $write_comment = true;
                                break;
                            }
                        }
                    }

                    // Si l'utilisateur a accès à la commande, créer 0 à 3 commentaires pour la commande actuel dont l'auteur est l'utilisateur actuel
                    if ($write_comment) {
                        Comment::factory(rand(0, 3))
                            ->make()
                            ->each(function (Comment $comment) use ($order, $user) {
                                $comment->order_id = $order->id;
                                $comment->author_id = $user->id;
                                $comment->save();
                            });
                    }
                }
            });
    }
}
