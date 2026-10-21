<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Espace caissier : recherche d'un compte, dépôt et retrait d'argent
class CashierController extends Controller
{
    // accueil : saisie d'un numéro de compte
    public function home()
    {
        return view('cashier.home');
    }

    public function searchaccount(Request $request)
    {
        $request->validate(['otherNo' => 'required']);
        $account = Account::where('account_no', $request->input('otherNo'))->first();

        if (! $account) {
            return back()->with('error', 'Aucun compte trouvé avec ce numéro');
        }

        return redirect('/cashier/account/'.$account->id);
    }

    // informations du compte + formulaires de dépôt / retrait
    public function account($id)
    {
        $account = Account::findOrFail($id);

        return view('cashier.account')->with('account', $account);
    }

    public function withdraw($id, Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $account = Account::findOrFail($id);
        $amount = $request->input('amount');

        $ok = DB::transaction(function () use ($account, $amount) {
            // retrait seulement si le solde est suffisant
            $debited = Account::where('id', $account->id)->where('balance', '>=', $amount)->decrement('balance', $amount);
            if (! $debited) {
                return false;
            }

            $transaction = new Transaction();
            $transaction->account_id = $account->id;
            $transaction->action = 'withdraw';
            $transaction->debit = $amount;
            $transaction->save();

            return true;
        });

        if (! $ok) {
            return back()->with('error', 'Solde insuffisant pour ce retrait');
        }

        return back()->with('status', 'Retrait de Rs.'.$amount.' effectué avec succès');
    }

    public function deposit($id, Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $account = Account::findOrFail($id);
        $amount = $request->input('amount');

        DB::transaction(function () use ($account, $amount) {
            Account::where('id', $account->id)->increment('balance', $amount);

            $transaction = new Transaction();
            $transaction->account_id = $account->id;
            $transaction->action = 'deposit';
            $transaction->credit = $amount;
            $transaction->save();
        });

        return back()->with('status', 'Dépôt de Rs.'.$amount.' effectué avec succès');
    }
}
