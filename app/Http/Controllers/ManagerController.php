<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

// Pages de l'espace manager
class ManagerController extends Controller
{
    // accueil : liste de tous les comptes clients avec le nom de leur agence
    public function home()
    {
        $accounts = DB::table('accounts')
            ->join('branches', 'accounts.branch_id', '=', 'branches.id')
            ->select('accounts.*', 'branches.branch_name')
            ->orderBy('accounts.id')
            ->get();

        return view('manager.home')->with('accounts', $accounts);
    }

    // formulaire de création d'un compte client
    public function addaccount()
    {
        // numéro de compte unique généré automatiquement
        do {
            $accountNo = (string) random_int(1000000000, 9999999999);
        } while (DB::table('accounts')->where('account_no', $accountNo)->exists());

        $branches = DB::table('branches')->get();

        return view('manager.addaccount')->with('accountNo', $accountNo)->with('branches', $branches);
    }

    // liste des feedbacks avec le nom, le n° de compte et le contact du client
    public function feedback()
    {
        $feedbacks = DB::table('feedbacks')
            ->join('accounts', 'feedbacks.account_id', '=', 'accounts.id')
            ->select('feedbacks.*', 'accounts.name', 'accounts.account_no', 'accounts.contact')
            ->latest('feedbacks.created_at')
            ->get();

        return view('manager.feedback')->with('feedbacks', $feedbacks);
    }
}
