{{-- Transfert de fonds, étape 2 : infos du destinataire + montant à envoyer (template : transfe.html) --}}
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

            <div class="alert alert-success w-50 mx-auto">
                <form method="POST" action="{{ url('/transfer/send') }}">
                    @csrf
                    {{-- Informations du destinataire (lecture seule) --}}
                    Account No.
                    <input type="text" value="{{ $receiver->account_no }}" name="otherNo" class="form-control" readonly required>
                    Account Holder Name.
                    <input type="text" class="form-control" value="{{ $receiver->name }}" readonly>
                    Account Holder Bank Name.
                    <input type="text" class="form-control" value="MCB Bank" readonly>
                    {{-- Montant : ne peut pas dépasser le solde du client --}}
                    Enter Amount for transfer.
                    <input type="number" name="amount" class="form-control" min="1" max="{{ $account->balance }}" step="0.01" required>
                    <button type="submit" class="btn btn-primary btn-sm my-1">Transfer</button>
                    <a href="{{ url('/transfer') }}" class="btn btn-secondary btn-sm my-1">Cancel</a>
                </form>
            </div>
            <br>

            @include('client.partials.transferhistory')
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
