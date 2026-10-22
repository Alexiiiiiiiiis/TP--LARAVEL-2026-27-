<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Transfert de fonds entre deux comptes de la banque
class TransferController extends Controller
{
    private function account()
    {
        return DB::table('accounts')->where('id', session('user_id'))->firstOrFail();
    }

    // historique des virements envoyés par le client
    private function history($account)
    {
        return DB::table('transactions')
            ->where('account_id', $account->id)
            ->where('action', 'transfer')
            ->latest()
            ->get();
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
        $receiver = DB::table('accounts')->where('account_no', $request->input('otherNo'))->first();

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
        $receiver = DB::table('accounts')->where('account_no', $request->input('otherNo'))->first();
        $amount = $request->input('amount');

        if ($receiver->id === $account->id) {
            return redirect('/transfer')->with('error', 'Vous ne pouvez pas faire un virement vers votre propre compte');
        }

        // tout se fait dans une transaction SQL : soit tout passe, soit rien
        $ok = DB::transaction(function () use ($account, $receiver, $amount) {
            // on ne débite que si le solde est suffisant
            $debited = DB::table('accounts')
                ->where('id', $account->id)
                ->where('balance', '>=', $amount)
                ->decrement('balance', $amount);
            if (! $debited) {
                return false;
            }
            DB::table('accounts')->where('id', $receiver->id)->increment('balance', $amount);

            // une ligne dans le relevé de chacun des deux comptes
            DB::table('transactions')->insert([
                [
                    'account_id' => $account->id,
                    'action' => 'transfer',
                    'debit' => $amount,
                    'credit' => null,
                    'other' => $receiver->account_no,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'account_id' => $receiver->id,
                    'action' => 'received',
                    'debit' => null,
                    'credit' => $amount,
                    'other' => $account->account_no,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            return true;
        });

        if (! $ok) {
            return redirect('/transfer')->with('error', 'Solde insuffisant pour ce virement');
        }

        return redirect('/transfer')->with('status', 'Virement de Rs.'.$amount.' effectué vers le compte '.$receiver->account_no);
    }
}
