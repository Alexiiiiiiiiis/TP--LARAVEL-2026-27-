<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Connexion des 3 types d'utilisateurs : client, manager, caissier
class AuthController extends Controller
{
    // page de connexion
    public function loginform()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required|in:client,manager,cashier',
        ]);

        $type = $request->input('type');

        // un client se connecte avec son compte bancaire,
        // le manager et les caissiers avec un compte du personnel
        if ($type === 'client') {
            $user = DB::table('accounts')->where('email', $request->input('email'))->first();
        } else {
            $user = DB::table('staff')->where('email', $request->input('email'))->where('role', $type)->first();
        }

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            return back()->withInput()->with('error', 'Email ou mot de passe incorrect');
        }

        // on garde en session qui est connecté et avec quel rôle
        $request->session()->regenerate();
        $request->session()->put('role', $type);
        $request->session()->put('user_id', $user->id);

        if ($type === 'manager') {
            return redirect('/manager');
        }
        if ($type === 'cashier') {
            return redirect('/cashier');
        }

        return redirect('/home');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/login')->with('status', 'Vous êtes déconnecté');
    }
}
