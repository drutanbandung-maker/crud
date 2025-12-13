<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        $transactions = $wallet ? $wallet->transactions()->latest()->get() : collect();
        return view('profile.wallet', compact('wallet','transactions'));
    }
}
