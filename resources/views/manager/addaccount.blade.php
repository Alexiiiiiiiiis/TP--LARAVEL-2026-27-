{{-- Création d'un compte bancaire client (template : maddnew.html) --}}
{{-- Le numéro de compte est généré automatiquement par le contrôleur --}}
@extends('layouts.manager')

@section('title', 'New Account')

@section('contenu')
<div class="container">
    <div class="card w-100 text-center shadowBlue">
        <div class="card-header">
            New Account Form
        </div>
        <div class="card-body bg-dark text-white">
            @include('layouts.partials.alerts')

            {{-- enctype obligatoire pour envoyer la photo --}}
            <form method="POST" action="{{ url('/manager/saveaccount') }}" enctype="multipart/form-data">
                @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td><input type="text" name="name" value="{{ old('name') }}" class="form-control input-sm" required></td>
                            <th>CNIC</th>
                            <td><input type="number" name="cnic" value="{{ old('cnic') }}" class="form-control input-sm" required></td>
                        </tr>
                        <tr>
                            <th>Account Number</th>
                            <td><input type="text" name="accountNo" readonly value="{{ $accountNo }}" class="form-control input-sm" required></td>
                            <th>Account Type</th>
                            <td>
                                <select class="form-control input-sm" name="accountType" required>
                                    <option value="saving" {{ old('accountType') !== 'current' ? 'selected' : '' }}>Saving</option>
                                    <option value="current" {{ old('accountType') === 'current' ? 'selected' : '' }}>Current</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><input type="text" name="city" value="{{ old('city') }}" class="form-control input-sm" required></td>
                            <th>Address</th>
                            <td><input type="text" name="address" value="{{ old('address') }}" class="form-control input-sm" required></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><input type="email" name="email" value="{{ old('email') }}" class="form-control input-sm" required></td>
                            <th>Password</th>
                            <td><input type="password" name="password" minlength="4" class="form-control input-sm" required></td>
                        </tr>
                        <tr>
                            <th>Deposit</th>
                            <td><input type="number" name="balance" value="{{ old('balance') }}" min="500" class="form-control input-sm" required></td>
                            <th>Source of income</th>
                            <td><input type="text" name="source" value="{{ old('source') }}" class="form-control input-sm" required></td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <td><input type="text" name="number" value="{{ old('number') }}" class="form-control input-sm" required></td>
                            <th>Branch</th>
                            <td>
                                {{-- liste des agences enregistrées en base --}}
                                <select class="form-control input-sm" name="branch" required>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch') == $branch->id ? 'selected' : '' }}>{{ $branch->branch_name }} ({{ $branch->branch_code }})</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Photo</th>
                            <td colspan="3">
                                <input type="file" name="image" accept="image/*" class="form-control input-sm">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <button type="submit" class="btn btn-primary btn-sm">Save Account</button>
                                <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection
