<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Notice;
use Illuminate\Http\Request;

// Notifications envoyées par le manager à un client
class NoticeController extends Controller
{
    public function noticeform($id)
    {
        $account = Account::findOrFail($id);

        return view('manager.notice')->with('account', $account);
    }

    public function sendnotice($id, Request $request)
    {
        $request->validate(['notice' => 'required|max:1000']);
        $account = Account::findOrFail($id);

        $notice = new Notice();
        $notice->account_id = $account->id;
        $notice->notice = $request->input('notice');
        $notice->save();

        return redirect('/manager')->with('status', 'La notification a été envoyée à '.$account->name);
    }
}
