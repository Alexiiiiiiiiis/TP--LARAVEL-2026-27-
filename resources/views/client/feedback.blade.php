{{-- Formulaire de feedback : le client envoie un message à la banque (template : feedback.html) --}}
@extends('layouts.client')

@section('title', 'Feedback')

@section('contenu')
<div class="container">
    <div class="card w-75 mx-auto">
        <div class="card-header text-center">
            Help Card
        </div>
        <div class="card-body">
            @include('layouts.partials.alerts')

            <form method="POST" action="{{ url('/savefeedback') }}">
                @csrf
                <div class="alert alert-success w-50 mx-auto">
                    <h5>Enter your message</h5>
                    <textarea class="form-control" name="msg" required placeholder="Write your message"></textarea>
                    <button type="submit" class="btn btn-primary btn-block btn-sm my-1">Send</button>
                </div>
            </form>
            <br>
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
