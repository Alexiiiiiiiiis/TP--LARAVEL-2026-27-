{{-- Compte trouvé par le caissier : infos + retrait / dépôt d'argent (template : cindex1.html) --}}
@extends('layouts.cashier')

@section('title', 'Cashier')

@section('contenu')
<div class="row w-100" style="padding: 11px">
    <div class="col">
        <div class="card text-center w-75 mx-auto">
            <div class="card-header">
                Account Information
            </div>
            <div class="card-body">
                @include('layouts.partials.alerts')

                <div class="row">
                    {{-- Informations du compte (lecture seule) --}}
                    <div class="col">
                        Account No.
                        <input type="text" value="{{ $account->account_no }}" class="form-control" readonly>
                        Account Holder Name.
                        <input type="text" class="form-control" value="{{ $account->name }}" readonly>
                        Account Holder Bank Name.
                        <input type="text" class="form-control" value="MCB Bank" readonly>
                        Bank Balance
                        <input type="text" class="form-control my-1" value="Rs.{{ number_format($account->balance, 2) }}" readonly>
                    </div>

                    {{-- Opérations au guichet --}}
                    <div class="col">
                        Transaction Process.
                        {{-- Retrait : ne peut pas dépasser le solde --}}
                        <form method="POST" action="{{ url('/cashier/withdraw/'.$account->id) }}">
                            @csrf
                            <div class="form-group">
                                <input type="number" class="form-control my-1" name="amount" placeholder="Write Amount for withdraw" min="1" max="{{ $account->balance }}" step="0.01" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm my-1">Withdraw</button>
                        </form>

                        {{-- Dépôt --}}
                        <form method="POST" action="{{ url('/cashier/deposit/'.$account->id) }}">
                            @csrf
                            <div class="form-group">
                                <input type="number" class="form-control my-1" name="amount" placeholder="Write Amount for deposit" min="1" step="0.01" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm my-1">Deposit</button>
                        </form>
                    </div>
                </div>
                <a href="{{ url('/cashier') }}" class="btn btn-secondary btn-sm mt-2">Search another account</a>
            </div>
            <div class="card-footer text-muted">
                MCB Bank
            </div>
        </div>
    </div>
</div>
@endsection
