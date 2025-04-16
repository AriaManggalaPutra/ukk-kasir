<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }


    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('admin-dashboard')->with('success', 'Berhasil Login Sebagai admin');
            } elseif ($user->role == 'petugas') {
                return redirect()->route('petugas-dashboard')->with('success', 'Berhasil Login Sebagai petugas');
            }

            return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar');
        }

        return back()->withErrors([
            'email' => 'Email atau Password anda salah.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', "Anda telah berhasil logout.");
    }

}
