<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Check if wallet doesn't exist
            if (!$user->wallet) {
                // Talent users get 1000 coins, customer users get 500 coins
                $coins = $user->role === 'talent' ? 1000 : 500;

                Wallet::create([
                    'id_coin' => $user->id,
                    'coins' => $coins,
                ]);
            }
        }
    }
}
