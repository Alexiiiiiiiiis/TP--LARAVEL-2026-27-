<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
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
            $account = new Account();
            $account->name = $request->input('name');
            $account->cnic = $request->input('cnic');
            $account->account_no = $request->input('accountNo');
            $account->account_type = $request->input('accountType');
            $account->city = $request->input('city');
            $account->address = $request->input('address');
            $account->email = $request->input('email');
            $account->password = Hash::make($request->input('password'));
            $account->balance = $request->input('balance');
            $account->source = $request->input('source');
            $account->contact = $request->input('number');
            $account->branch_id = $request->input('branch');
            $account->image = $fileNameToStore;
            $account->save();

            // le dépôt initial apparaît dans le relevé bancaire
            $transaction = new Transaction();
            $transaction->account_id = $account->id;
            $transaction->action = 'deposit';
            $transaction->credit = $account->balance;
            $transaction->save();
        });

        return redirect('/manager')->with('status', 'Le compte a été créé avec succès');
    }

    // détails d'un client
    public function showaccount($id)
    {
        $account = Account::with('branch')->findOrFail($id);

        return view('manager.show')->with('account', $account);
    }

    public function deleteaccount($id)
    {
        $account = Account::findOrFail($id);

        // suppression de la photo du client
        if ($account->image) {
            File::delete(public_path('assets/images/clients/'.$account->image));
        }

        // les opérations, feedbacks et notifications sont supprimés en cascade
        $account->delete();

        return back()->with('status', 'Le compte a été supprimé avec succès');
    }
}
