{{-- Notifications envoyées par la banque au client (template : notice.html) --}}
@extends('layouts.client')

@section('title', 'Notice')

@section('contenu')
<div class="container">
    <div class="card w-75 mx-auto">
        <div class="card-header text-center">
            Notification from Bank
        </div>
        <div class="card-body">
            @forelse ($notices as $notice)
                <div class="alert alert-success">Dear {{ $account->name }},<br>
                    {{ $notice->notice }}
                    <br><small class="text-muted">{{ $notice->created_at }}</small>
                </div>
            @empty
                <div class="alert alert-light">No notification for now.</div>
            @endforelse
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
