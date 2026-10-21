{{-- Transfert de fonds, étape 1 : saisie du numéro de compte du destinataire (template : transfer.html) --}}
@extends('layouts.client')

@section('title', 'Funds Transfer')

@section('contenu')
<div class="container">
    <div class="card w-75 mx-auto">
        <div class="card-header text-center">
            Funds Transfer
        </div>
        <div class="card-body">
            @include('layouts.partials.alerts')

            {{-- Recherche du compte destinataire --}}
            <form method="GET" action="{{ url('/transfer/search') }}">
                <div class="alert alert-success w-50 mx-auto">
                    <h5>New Transfer</h5>
                    <input type="text" name="otherNo" class="form-control" placeholder="Enter Receiver Account number" required>
                    <button type="submit" class="btn btn-primary btn-sm my-1">Get Account Info</button>
                </div>
            </form>
            <br>

            @include('client.partials.transferhistory')
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
