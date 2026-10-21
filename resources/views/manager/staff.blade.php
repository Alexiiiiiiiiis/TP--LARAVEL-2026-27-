{{-- CRUD des caissiers (template : maccounts.html) --}}
{{-- Ajout et modification se font dans des fenêtres modales Bootstrap --}}
@extends('layouts.manager')

@section('title', 'Cashiers')

@section('contenu')
<div class="container">
    <div class="card w-100 text-center shadowBlue">
        <div class="card-header">
            All Cashier Accounts
            <button class="btn btn-outline-success btn-sm float-right" data-toggle="modal" data-target="#modalAdd">Add New Cashier</button>
        </div>
        <div class="card-body bg-dark text-white">
            @include('layouts.partials.alerts')

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Account Type</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cashiers as $cashier)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cashier->email }}</td>
                            <td>{{ $cashier->role }}</td>
                            <td>{{ $cashier->created_at }}</td>
                            <td>
                                {{-- chaque caissier a sa propre modale de modification --}}
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdate{{ $cashier->id }}">Edit</button>
                                <form action="{{ url('/manager/deletecashier/'.$cashier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this cashier ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No cashier yet.</td>
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

{{-- Modale d'ajout d'un caissier --}}
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">New Cashier Account</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/manager/savecashier') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control w-75 mx-auto" type="email" name="email" required placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input class="form-control w-75 mx-auto" type="password" name="password" required minlength="4" placeholder="Password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modales de modification (une par caissier) --}}
@foreach ($cashiers as $cashier)
    <div class="modal fade" id="modalUpdate{{ $cashier->id }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel{{ $cashier->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateLabel{{ $cashier->id }}">Edit Cashier Account</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ url('/manager/updatecashier/'.$cashier->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input class="form-control w-75 mx-auto" type="email" name="email" value="{{ $cashier->email }}" required placeholder="Email">
                        </div>
                        <div class="form-group">
                            {{-- laisser vide pour garder le mot de passe actuel --}}
                            <input class="form-control w-75 mx-auto" type="password" name="password" minlength="4" placeholder="New password (leave empty to keep)">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
