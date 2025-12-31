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

        $orders = Order::factory($nbOrders)->create();
        //            ->make()
        //            ->each(function (Order $order) use ($suppliers) {
        //                $order->supplier()->($suppliers->random());
        //                $order->save(); // utile de les sauvegarder un par un ?
        //            });

        $suppliers = Supplier::factory($nbSuppliers)
            ->hasOrders(7)
            ->create();

        $comments = Comment::factory($nbUsers * rand(2, 6))
            ->make()
            ->each(function (Comment $comment) use ($orders) {
                $comment->order()->associate($orders->random());
            });

        $users = User::factory($nbUsers)
            ->create()
            ->each(function (User $user) use ($comments) {
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

                $user->roles()->sync($roles);

                // Chaque utilisateur peut avoir plusieurs commentaires uniquement sur les commandes créés par un membre du même rôle/département
                $user->hasMany($comments->filter(
                    function (Comment $comment) use ($roles, $hasSecondRole) {
                        // TODO pas sûr d'avoir bien compris le principe de BelongsTo, HasMany et compagnie. À VOIR
                        dd($comment->order());

                        return ! $comment->order()->logs()->where('id', 1)->user()->roles()->find(function (Role $role) use ($roles, $hasSecondRole) {
                            return $role === $roles[0] || ($hasSecondRole && $role === $roles[1]);
                        });
                    }
                )->random());
            });

        $packages = Package::factory($nbOrders * rand(2, 5))
            ->make()
            ->each(function (Package $p) use ($orders) {
                $p->order()->associate($orders->random());
                $p->save();
            });

        $logs = Log::factory($nbUsers * rand(2, 6))
            ->make()
            ->each(function (Log $log) use ($orders) {
                $log->order()->associate($orders->random());
            });

    }
}
