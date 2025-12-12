<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function show($token)
    {
        $reset = DB::table('password_resets')->where('token', $token)->first();

        if (!$reset || now()->diffInMinutes($reset->created_at) > 60) {
            return redirect()->route('login')->with('error', 'Link reset password tidak valid atau sudah kadaluarsa');
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $reset->email]);
    }

    public function reset(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.exists' => 'Email tidak ditemukan',
            'password.required' => 'Password baru wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // verify token
        $reset = DB::table('password_resets')->where('token', $request->token)->where('email', $request->email)->first();

        if (!$reset || now()->diffInMinutes($reset->created_at) > 60) {
            return back()->with('error', 'Link reset password tidak valid atau sudah kadaluarsa');
        }

        // update password
        User::where('email', $request->email)->update(['password' => Hash::make($validated['password'])]);

        // delete token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda');
    }
}
