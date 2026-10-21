{{-- Page de connexion (template : login.html) --}}
{{-- 3 formulaires : client (User), manager, caissier (Cashier). Le champ caché "type" indique lequel est utilisé. --}}
@extends('layouts.master')

@section('title', 'Login')

@section('body_style', "background: url(".asset('assets/images/bg-login2.jpg').");background-size: 100%")

@section('contenu')
<h1 class="alert alert-success rounded-0">MCB Bank<small class="float-right text-muted" style="font-size: 12pt;"><kbd>Online Banking</kbd></small></h1>
<br>
<br>
<div id="accordion" role="tablist" class="w-25 float-right shadowBlack" style="margin-right: 222px; min-width: 280px">
    <br><h4 class="text-center text-white">Select Your Session</h4>

    {{-- Messages (erreur de connexion, déconnexion...) --}}
    @include('layouts.partials.alerts')

    {{-- Connexion client --}}
    <div class="card rounded-0">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a class="btn btn-outline-success btn-block" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">User Login</a>
            </h5>
        </div>
        {{-- le volet reste ouvert si la dernière tentative venait de ce formulaire --}}
        <div id="collapseOne" class="collapse {{ old('type') === 'client' ? 'show' : '' }}" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <input type="hidden" name="type" value="client">
                    <input type="email" value="{{ old('type') === 'client' ? old('email') : 'ali@mcbbank.com' }}" name="email" class="form-control" required placeholder="Enter Email">
                    <input type="password" name="password" class="form-control" required placeholder="Enter Password">
                    <button type="submit" class="btn btn-primary btn-block btn-sm my-1">Enter</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Connexion manager --}}
    <div class="card rounded-0">
        <div class="card-header" role="tab" id="headingTwo">
            <h5 class="mb-0">
                <a class="collapsed btn btn-outline-success btn-block" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Manager Login</a>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse {{ old('type') === 'manager' ? 'show' : '' }}" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <input type="hidden" name="type" value="manager">
                    <input type="email" value="{{ old('type') === 'manager' ? old('email') : 'manager@mcbbank.com' }}" name="email" class="form-control" required placeholder="Enter Email">
                    <input type="password" name="password" class="form-control" required placeholder="Enter Password">
                    <button type="submit" class="btn btn-primary btn-block btn-sm my-1">Enter</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Connexion caissier --}}
    <div class="card rounded-0">
        <div class="card-header" role="tab" id="headingThree">
            <h5 class="mb-0">
                <a class="collapsed btn btn-outline-success btn-block" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Cashier Login</a>
            </h5>
        </div>
        <div id="collapseThree" class="collapse {{ old('type') === 'cashier' ? 'show' : '' }}" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <input type="hidden" name="type" value="cashier">
                    <input type="email" value="{{ old('type') === 'cashier' ? old('email') : 'cashier@mcbbank.com' }}" name="email" class="form-control" required placeholder="Enter Email">
                    <input type="password" name="password" class="form-control" required placeholder="Enter Password">
                    <button type="submit" class="btn btn-primary btn-block btn-sm my-1">Enter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
