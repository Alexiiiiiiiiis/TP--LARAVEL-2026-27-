{{-- Détails du compte bancaire du client connecté (template : accounts.html) --}}
@extends('layouts.client')

@section('title', 'Account')

@section('contenu')
<div class="container">
    <div class="card w-75 mx-auto">
        <div class="card-header text-center">
            Your account Information
        </div>
        <div class="card-body">
            {{-- Photo du client --}}
            <div class="text-center">
                <img src="{{ $account->image ? asset('assets/images/clients/'.$account->image) : asset('assets/images/hillary.jpg') }}" height="150" width="150" alt="" class="rounded-circle m-2" style="border : 5px solid #555; object-fit: cover">
            </div>
            <table class="table table-striped table-dark w-75 mx-auto">
                <thead>
                    <tr>
                        <td scope="col">Account No.</td>
                        <th scope="col">{{ $account->account_no }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Holder Name</th>
                        <td>{{ $account->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Branch</th>
                        <td>{{ $account->branch_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Branch Code</th>
                        <td>{{ $account->branch_code }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Account Type</th>
                        <td>{{ ucfirst($account->account_type) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Current Balance</th>
                        <td>Rs.{{ number_format($account->balance, 2) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Account Created</th>
                        <td>{{ $account->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
