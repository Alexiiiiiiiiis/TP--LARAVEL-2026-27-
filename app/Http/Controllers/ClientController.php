<?php

namespace App\Http\Controllers;

use App\Models\Account;

// Pages de l'espace client
class ClientController extends Controller
{
    // compte du client connecté
    private function account()
    {
        return Account::with('branch')->findOrFail(session('user_id'));
    }

    // accueil : affiche la dernière notification reçue
    public function home()
    {
        $account = $this->account();
        $lastNotice = $account->notices()->latest()->first();

        return view('client.home')->with('account', $account)->with('lastNotice', $lastNotice);
    }

    // détails du compte bancaire
    public function accounts()
    {
        return view('client.accounts')->with('account', $this->account());
    }

    // relevé bancaire : toutes les opérations du compte
    public function statements()
    {
        $account = $this->account();
        $transactions = $account->transactions()->latest()->get();

        return view('client.statements')->with('account', $account)->with('transactions', $transactions);
    }

    // notifications envoyées par la banque
    public function notice()
    {
        $account = $this->account();
        $notices = $account->notices()->latest()->get();

        return view('client.notice')->with('account', $account)->with('notices', $notices);
    }

    // formulaire de feedback
    public function feedback()
    {
        return view('client.feedback')->with('account', $this->account());
    }
}
