<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $wallets = Wallet::all();

        foreach ($wallets as $wallet) {
            // Add dummy transactions for each wallet
            Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => 100,
                'description' => 'Initial bonus',
            ]);

            Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => 50,
                'description' => 'Purchase service',
            ]);

            Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => 250,
                'description' => 'Task completion reward',
            ]);

            Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => 75,
                'description' => 'Transaction fee',
            ]);
        }
    }
}
