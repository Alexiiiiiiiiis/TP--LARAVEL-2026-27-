<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Feedback : envoi par le client, suppression par le manager
class FeedbackController extends Controller
{
    public function savefeedback(Request $request)
    {
        $request->validate(['msg' => 'required|max:1000']);

        DB::table('feedbacks')->insert([
            'account_id' => session('user_id'),
            'message' => $request->input('msg'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('status', 'Votre message a été envoyé avec succès');
    }

    public function deletefeedback($id)
    {
        DB::table('feedbacks')->where('id', $id)->firstOrFail();
        DB::table('feedbacks')->where('id', $id)->delete();

        return back()->with('status', 'Le feedback a été supprimé avec succès');
    }
}
