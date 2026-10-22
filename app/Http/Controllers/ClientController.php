<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

// Pages de l'espace client
class ClientController extends Controller
{
    // compte du client connecté, avec le nom et le code de son agence
    private function account()
    {
        return DB::table('accounts')
            ->join('branches', 'accounts.branch_id', '=', 'branches.id')
            ->select('accounts.*', 'branches.branch_name', 'branches.branch_code')
            ->where('accounts.id', session('user_id'))
            ->firstOrFail();
    }

    // accueil : affiche la dernière notification reçue
    public function home()
    {
        $account = $this->account();
        $lastNotice = DB::table('notices')->where('account_id', $account->id)->latest()->first();

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
        $transactions = DB::table('transactions')->where('account_id', $account->id)->latest()->get();

        return view('client.statements')->with('account', $account)->with('transactions', $transactions);
    }

    // notifications envoyées par la banque
    public function notice()
    {
        $account = $this->account();
        $notices = DB::table('notices')->where('account_id', $account->id)->latest()->get();

        return view('client.notice')->with('account', $account)->with('notices', $notices);
    }

    // formulaire de feedback
    public function feedback()
    {
        return view('client.feedback')->with('account', $this->account());
    }
}
