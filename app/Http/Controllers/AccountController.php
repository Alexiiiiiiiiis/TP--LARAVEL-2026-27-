<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

// Comptes clients : création, affichage des détails, suppression
class AccountController extends Controller
{
    public function saveaccount(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cnic' => 'required|numeric',
            'accountNo' => 'required|unique:accounts,account_no',
            'accountType' => 'required|in:current,saving',
            'city' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|min:4',
            'balance' => 'required|numeric|min:500',
            'source' => 'required',
            'number' => 'required',
            'branch' => 'required|exists:branches,id',
            'image' => 'nullable|image|max:1999',
        ]);

        // enregistrement de la photo dans public/assets/images/clients
        $fileNameToStore = null;
        if ($request->hasFile('image')) {
            $ext = $request->file('image')->extension();
            $fileNameToStore = 'client_'.time().'_'.uniqid().'.'.$ext;
            $request->file('image')->move(public_path('assets/images/clients'), $fileNameToStore);
        }

        DB::transaction(function () use ($request, $fileNameToStore) {
            $accountId = DB::table('accounts')->insertGetId([
                'name' => $request->input('name'),
                'cnic' => $request->input('cnic'),
                'account_no' => $request->input('accountNo'),
                'account_type' => $request->input('accountType'),
                'city' => $request->input('city'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'balance' => $request->input('balance'),
                'source' => $request->input('source'),
                'contact' => $request->input('number'),
                'branch_id' => $request->input('branch'),
                'image' => $fileNameToStore,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // le dépôt initial apparaît dans le relevé bancaire
            DB::table('transactions')->insert([
                'account_id' => $accountId,
                'action' => 'deposit',
                'credit' => $request->input('balance'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect('/manager')->with('status', 'Le compte a été créé avec succès');
    }

    // détails d'un client, avec le nom et le code de son agence
    public function showaccount($id)
    {
        $account = DB::table('accounts')
            ->join('branches', 'accounts.branch_id', '=', 'branches.id')
            ->select('accounts.*', 'branches.branch_name', 'branches.branch_code')
            ->where('accounts.id', $id)
            ->firstOrFail();

        return view('manager.show')->with('account', $account);
    }

    public function deleteaccount($id)
    {
        $account = DB::table('accounts')->where('id', $id)->firstOrFail();

        // suppression de la photo du client
        if ($account->image) {
            File::delete(public_path('assets/images/clients/'.$account->image));
        }

        // les opérations, feedbacks et notifications sont supprimés en cascade
        DB::table('accounts')->where('id', $id)->delete();

        return back()->with('status', 'Le compte a été supprimé avec succès');
    }
}
