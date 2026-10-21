<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Transfert de fonds entre deux comptes de la banque
class TransferController extends Controller
{
    private function account()
    {
        return Account::findOrFail(session('user_id'));
    }

    // historique des virements envoyés par le client
    private function history(Account $account)
    {
        return $account->transactions()->where('action', 'transfer')->latest()->get();
    }

    // étape 1 : saisie du numéro de compte du destinataire
    public function transfer()
    {
        $account = $this->account();

        return view('client.transfer')->with('account', $account)->with('history', $this->history($account));
    }

    // étape 2 : affichage des infos du destinataire + saisie du montant
    public function searchaccount(Request $request)
    {
        $request->validate(['otherNo' => 'required']);

        $account = $this->account();
        $receiver = Account::where('account_no', $request->input('otherNo'))->first();

        if (! $receiver) {
            return redirect('/transfer')->with('error', 'Aucun compte trouvé avec ce numéro');
        }
        if ($receiver->id === $account->id) {
            return redirect('/transfer')->with('error', 'Vous ne pouvez pas faire un virement vers votre propre compte');
        }

        return view('client.transferconfirm')
            ->with('account', $account)
            ->with('receiver', $receiver)
            ->with('history', $this->history($account));
    }

    // étape 3 : virement
    public function sendtransfer(Request $request)
    {
        $request->validate([
            'otherNo' => 'required|exists:accounts,account_no',
            'amount' => 'required|numeric|min:1',
        ]);

        $account = $this->account();
        $receiver = Account::where('account_no', $request->input('otherNo'))->first();
        $amount = $request->input('amount');

        if ($receiver->id === $account->id) {
            return redirect('/transfer')->with('error', 'Vous ne pouvez pas faire un virement vers votre propre compte');
        }

        // tout se fait dans une transaction SQL : soit tout passe, soit rien
        $ok = DB::transaction(function () use ($account, $receiver, $amount) {
            // on ne débite que si le solde est suffisant
            $debited = Account::where('id', $account->id)->where('balance', '>=', $amount)->decrement('balance', $amount);
            if (! $debited) {
                return false;
            }
            Account::where('id', $receiver->id)->increment('balance', $amount);

            // une ligne dans le relevé de chacun des deux comptes
            $out = new Transaction();
            $out->account_id = $account->id;
            $out->action = 'transfer';
            $out->debit = $amount;
            $out->other = $receiver->account_no;
            $out->save();

            $in = new Transaction();
            $in->account_id = $receiver->id;
            $in->action = 'received';
            $in->credit = $amount;
            $in->other = $account->account_no;
            $in->save();

            return true;
        });

        if (! $ok) {
            return redirect('/transfer')->with('error', 'Solde insuffisant pour ce virement');
        }

        return redirect('/transfer')->with('status', 'Virement de Rs.'.$amount.' effectué vers le compte '.$receiver->account_no);
    }
}
