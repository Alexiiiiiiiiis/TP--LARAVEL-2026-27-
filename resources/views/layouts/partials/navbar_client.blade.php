{{-- Barre de navigation de l'espace client --}}
{{-- $account (compte du client connecté) est envoyé par le contrôleur à chaque page --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="{{ url('/home') }}">
        <img src="{{ asset('assets/images/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
        MCB Bank
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        {{-- Liens des pages (le lien de la page courante est mis en avant) --}}
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ url('/home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('accounts') ? 'active' : '' }}" href="{{ url('/accounts') }}">Accounts</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('statements') ? 'active' : '' }}" href="{{ url('/statements') }}">Account Statements</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('transfer*') ? 'active' : '' }}" href="{{ url('/transfer') }}">Funds Transfer</a></li>
        </ul>
        {{-- Solde du compte + raccourcis --}}
        <div class="form-inline my-2 my-lg-0">
            <span class="btn btn-outline-success" data-toggle="tooltip" title="Your current Account Balance">Account Balance : Rs.{{ number_format($account->balance, 2) }}</span>
            <a href="{{ url('/accounts') }}" data-toggle="tooltip" title="Account Summary" class="btn btn-outline-primary mx-1"><i class="fa fa-book fa-fw"></i></a>
            <a href="{{ url('/notice') }}" data-toggle="tooltip" title="View Notice" class="btn btn-outline-primary mx-1"><i class="fa fa-envelope fa-fw"></i></a>
            <a href="{{ url('/feedback') }}" data-toggle="tooltip" title="Help?" class="btn btn-outline-info mx-1"><i class="fa fa-question fa-fw"></i></a>
            <a href="{{ url('/logout') }}" data-toggle="tooltip" title="Logout" class="btn btn-outline-danger mx-1"><i class="fa fa-sign-out fa-fw"></i></a>
        </div>
    </div>
</nav><br><br><br>
