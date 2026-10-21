<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

// Feedback : envoi par le client, suppression par le manager
class FeedbackController extends Controller
{
    public function savefeedback(Request $request)
    {
        $request->validate(['msg' => 'required|max:1000']);

        $feedback = new Feedback();
        $feedback->account_id = session('user_id');
        $feedback->message = $request->input('msg');
        $feedback->save();

        return back()->with('status', 'Votre message a été envoyé avec succès');
    }

    public function deletefeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return back()->with('status', 'Le feedback a été supprimé avec succès');
    }
}
