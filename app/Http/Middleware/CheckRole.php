<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Vérifie que la personne connectée a le bon rôle (client, manager ou cashier)
// avant d'accéder à une page. Sinon, retour à la page de connexion.
class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->session()->get('role') !== $role) {
            return redirect('/login')->with('error', 'Veuillez vous connecter pour accéder à cette page');
        }

        // un client dont le compte a été supprimé entre-temps est déconnecté
        if ($role === 'client' && ! DB::table('accounts')->where('id', $request->session()->get('user_id'))->exists()) {
            $request->session()->flush();

            return redirect('/login')->with('error', "Ce compte n'existe plus");
        }

        return $next($request);
    }
}
