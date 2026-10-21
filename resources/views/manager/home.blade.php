{{-- Accueil du manager : liste de tous les comptes clients (template : mindex.html) --}}
{{-- Actions par compte : voir les détails, envoyer une notification, supprimer le compte --}}
@extends('layouts.manager')

@section('title', 'Manager')

@section('contenu')
<div class="container">
    <div class="card w-100 text-center shadowBlue">
        <div class="card-header">
            All accounts
            <a href="{{ url('/manager/addaccount') }}" class="btn btn-outline-success btn-sm float-right">Add New Account</a>
        </div>
        <div class="card-body">
            @include('layouts.partials.alerts')

            <table class="table table-bordered table-sm bg-dark text-white">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Holder Name</th>
                        <th scope="col">Account No.</th>
                        <th scope="col">Branch Name</th>
                        <th scope="col">Current Balance</th>
                        <th scope="col">Account type</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($accounts as $account)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $account->name }}</td>
                            <td>{{ $account->account_no }}</td>
                            <td>{{ $account->branch->branch_name }}</td>
                            <td>Rs.{{ number_format($account->balance, 2) }}</td>
                            <td>{{ ucfirst($account->account_type) }}</td>
                            <td>{{ $account->contact }}</td>
                            <td>
                                <a href="{{ url('/manager/showaccount/'.$account->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="View More info">View</a>
                                <a href="{{ url('/manager/notice/'.$account->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Send notice to this">Send Notice</a>
                                {{-- Suppression : formulaire DELETE avec confirmation --}}
                                <form action="{{ url('/manager/deleteaccount/'.$account->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this account and all its transactions ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete this account">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No account yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
