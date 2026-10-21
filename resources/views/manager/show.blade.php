{{-- Détails d'un client (template : mshow.html) --}}
@extends('layouts.manager')

@section('title', 'Account profile')

@section('contenu')
<div class="container">
    <div class="card w-100 text-center shadowBlue">
        <div class="card-header">
            Account profile for {{ $account->name }} <kbd>#{{ $account->account_no }}</kbd>
        </div>
        <div class="card-body bg-dark text-white">
            <div class="text-center">
                <img src="{{ $account->photo() }}" height="100" width="100" alt="" class="rounded-circle m-2" style="border : 2px solid #FFF; object-fit: cover">
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <th>{{ $account->name }}</th>
                        <td>Account No</td>
                        <th>{{ $account->account_no }}</th>
                    </tr>
                    <tr>
                        <td>Branch Name</td>
                        <th>{{ $account->branch->branch_name }}</th>
                        <td>Branch Code</td>
                        <th>{{ $account->branch->branch_code }}</th>
                    </tr>
                    <tr>
                        <td>Current Balance</td>
                        <th>Rs.{{ number_format($account->balance, 2) }}</th>
                        <td>Account Type</td>
                        <th>{{ ucfirst($account->account_type) }}</th>
                    </tr>
                    <tr>
                        <td>CNIC</td>
                        <th>{{ $account->cnic }}</th>
                        <td>City</td>
                        <th>{{ $account->city }}</th>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <th>{{ $account->contact }}</th>
                        <td>Address</td>
                        <th>{{ $account->address }}</th>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <th>{{ $account->email }}</th>
                        <td>Source of income</td>
                        <th>{{ $account->source }}</th>
                    </tr>
                    <tr>
                        <td>Account Created</td>
                        <th colspan="3">{{ $account->created_at }}</th>
                    </tr>
                </tbody>
            </table>
            <a href="{{ url('/manager') }}" class="btn btn-secondary btn-sm">Back</a>
            <a href="{{ url('/manager/notice/'.$account->id) }}" class="btn btn-primary btn-sm">Send Notice</a>
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
