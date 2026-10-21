{{-- Relevé bancaire : toutes les opérations du compte, de la plus récente à la plus ancienne (template : statements.html) --}}
@extends('layouts.client')

@section('title', 'Statements')

@section('contenu')
<div class="container">
    <div class="card w-75 mx-auto">
        <div class="card-header text-center">
            Transactions made against your account
        </div>
        <div class="card-body">
            {{-- Une ligne par opération : vert = argent reçu, gris = argent sorti --}}
            @forelse ($transactions as $transaction)
                @if ($transaction->action === 'deposit')
                    <div class="alert alert-success">You deposit Rs.{{ number_format($transaction->credit, 2) }} in your account at {{ $transaction->created_at }}</div>
                @elseif ($transaction->action === 'withdraw')
                    <div class="alert alert-secondary">You withdraw Rs.{{ number_format($transaction->debit, 2) }} from your account at {{ $transaction->created_at }}</div>
                @elseif ($transaction->action === 'transfer')
                    <div class="alert alert-warning">You transfer Rs.{{ number_format($transaction->debit, 2) }} to account no.{{ $transaction->other }} at {{ $transaction->created_at }}</div>
                @elseif ($transaction->action === 'received')
                    <div class="alert alert-info">You received Rs.{{ number_format($transaction->credit, 2) }} from account no.{{ $transaction->other }} at {{ $transaction->created_at }}</div>
                @endif
            @empty
                <div class="alert alert-light">No transaction yet.</div>
            @endforelse
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
