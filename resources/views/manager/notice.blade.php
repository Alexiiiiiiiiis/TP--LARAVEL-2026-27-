{{-- Envoi d'une notification à un client (template : mnotice.html) --}}
@extends('layouts.manager')

@section('title', 'Send Notice')

@section('contenu')
<div class="container">
    <div class="card w-100 text-center shadowBlue">
        <div class="card-header">
            Send Notice to {{ $account->name }}
        </div>
        <div class="card-body">
            @include('layouts.partials.alerts')

            <form method="POST" action="{{ url('/manager/sendnotice/'.$account->id) }}">
                @csrf
                <div class="alert alert-success w-50 mx-auto">
                    <h5>Write notice for {{ $account->name }}</h5>
                    <textarea class="form-control" name="notice" required placeholder="Write your message"></textarea>
                    <button type="submit" class="btn btn-primary btn-block btn-sm my-1">Send</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
