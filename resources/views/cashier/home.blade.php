{{-- Accueil du caissier : recherche d'un compte par son numéro (template : cindex.html) --}}
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

                <form method="POST" action="{{ url('/cashier/search') }}">
                    @csrf
                    <div class="alert alert-success w-50 mx-auto">
                        <h5>Enter Account Number</h5>
                        <div class="form-group">
                            <input type="text" name="otherNo" class="form-control" placeholder="Enter Account number" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm my-1">Get Account Info</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
                MCB Bank
            </div>
        </div>
    </div>
</div>
@endsection
