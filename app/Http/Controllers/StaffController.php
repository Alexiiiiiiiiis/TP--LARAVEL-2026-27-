<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
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

        $cashier = new Staff();
        $cashier->email = $request->input('email');
        $cashier->password = Hash::make($request->input('password'));
        $cashier->role = 'cashier';
        $cashier->save();

        return back()->with('status', 'Le caissier a été créé avec succès');
    }

    public function updatecashier($id, Request $request)
    {
        $cashier = Staff::where('role', 'cashier')->findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:staff,email,'.$cashier->id,
            'password' => 'nullable|min:4',
        ]);

        $cashier->email = $request->input('email');
        // le mot de passe n'est changé que s'il est rempli
        if ($request->filled('password')) {
            $cashier->password = Hash::make($request->input('password'));
        }
        $cashier->update();

        return back()->with('status', 'Le caissier a été modifié avec succès');
    }

    public function deletecashier($id)
    {
        $cashier = Staff::where('role', 'cashier')->findOrFail($id);
        $cashier->delete();

        return back()->with('status', 'Le caissier a été supprimé avec succès');
    }
}
