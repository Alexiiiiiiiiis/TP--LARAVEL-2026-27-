<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Branch;
use App\Models\Feedback;
use App\Models\Staff;

// Pages de l'espace manager
class ManagerController extends Controller
{
    // accueil : liste de tous les comptes clients
    public function home()
    {
        $accounts = Account::with('branch')->get();

        return view('manager.home')->with('accounts', $accounts);
    }

    // liste des caissiers (CRUD)
    public function staff()
    {
        $cashiers = Staff::where('role', 'cashier')->get();

        return view('manager.staff')->with('cashiers', $cashiers);
    }

    // formulaire de création d'un compte client
    public function addaccount()
    {
        // numéro de compte unique généré automatiquement
        do {
            $accountNo = (string) random_int(1000000000, 9999999999);
        } while (Account::where('account_no', $accountNo)->exists());

        $branches = Branch::get();

        return view('manager.addaccount')->with('accountNo', $accountNo)->with('branches', $branches);
    }

    // liste des feedbacks des clients
    public function feedback()
    {
        $feedbacks = Feedback::with('account')->latest()->get();

        return view('manager.feedback')->with('feedbacks', $feedbacks);
    }
}
