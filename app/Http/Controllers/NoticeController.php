<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Notifications envoyées par le manager à un client
class NoticeController extends Controller
{
    public function noticeform($id)
    {
        $account = DB::table('accounts')->where('id', $id)->firstOrFail();

        return view('manager.notice')->with('account', $account);
    }

    public function sendnotice($id, Request $request)
    {
        $request->validate(['notice' => 'required|max:1000']);
        $account = DB::table('accounts')->where('id', $id)->firstOrFail();

        DB::table('notices')->insert([
            'account_id' => $account->id,
            'notice' => $request->input('notice'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/manager')->with('status', 'La notification a été envoyée à '.$account->name);
    }
}
