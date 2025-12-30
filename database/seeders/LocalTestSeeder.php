<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        $nbSuppliers = 10;
        $nbUsers = 20;
        $nbOrders = 50;

        $suppliers = Supplier::factory($nbSuppliers)->create();
        // ->hasAttached(fake()->boolean(80) ? 1 : $roles->random_int(2, 3))

        $users = User::factory($nbUsers)->create()->each(function (User $user) {

            // Chaque utilisateur doit avoir au moins un rôle aléatoire
            $roles = [
                Role::all()->random(),
            ];

            // et dans 10% des cas un utilisateur a UN AUTRE, aussi aléatoire
            $role2 = Role::all()->random();
            if (random_int(0, 100) <= 10 && $roles[0] !== $role2) {
                array_push($roles, $role2);
            }

            $user->roles()->sync($roles);
        });

        $orders = Order::factory($nbOrders)
            ->hasAttached($suppliers->random())
            ->create();

        $packages = Package::factory($nbOrders * random_int(2, 5))
            ->hasAttached($orders->random())
            ->create();

        $logs = Log::factory($nbUsers * random_int(2, 6))
            ->hasAttached($users->random()) // users avec le rôle d'un département
            ->hasAttached($orders->random())
            ->create();

    }
}
