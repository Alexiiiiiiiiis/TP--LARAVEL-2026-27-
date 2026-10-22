<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// CRUD des caissiers (géré par le manager)
class StaffController extends Controller
{
    public function savecashier(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|min:4',
        ]);

        DB::table('staff')->insert([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'cashier',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('status', 'Le caissier a été créé avec succès');
    }

    public function updatecashier($id, Request $request)
    {
        $cashier = DB::table('staff')->where('role', 'cashier')->where('id', $id)->firstOrFail();

        $request->validate([
            'email' => 'required|email|unique:staff,email,'.$cashier->id,
            'password' => 'nullable|min:4',
        ]);

        $data = [
            'email' => $request->input('email'),
            'updated_at' => now(),
        ];

        // le mot de passe n'est changé que s'il est rempli
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        DB::table('staff')->where('id', $cashier->id)->update($data);

        return back()->with('status', 'Le caissier a été modifié avec succès');
    }

    public function deletecashier($id)
    {
        DB::table('staff')->where('role', 'cashier')->where('id', $id)->firstOrFail();
        DB::table('staff')->where('id', $id)->delete();

        return back()->with('status', 'Le caissier a été supprimé avec succès');
    }
}
