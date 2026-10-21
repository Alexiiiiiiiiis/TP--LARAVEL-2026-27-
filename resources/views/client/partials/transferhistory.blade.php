{{-- Historique des virements envoyés par le client (utilisé par les 2 pages de transfert) --}}
<h5>Transfer History</h5>
@forelse ($history as $transfer)
    <div class="alert alert-warning">Transfer has been made for Rs.{{ number_format($transfer->debit, 2) }} from your account at {{ $transfer->created_at }} to account no.{{ $transfer->other }}</div>
@empty
    <div class="alert alert-light">No transfer yet.</div>
@endforelse
