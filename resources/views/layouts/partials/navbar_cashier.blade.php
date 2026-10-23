{{-- Barre de navigation de l'espace caissier --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="{{ url('/cashier') }}">
        <img src="{{ asset('assets/images/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
        MCB Bank
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link active" href="{{ url('/cashier') }}">Home</a></li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <span class="btn btn-outline-success">Welcome Cashier</span>
            <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" data-toggle="tooltip" title="Logout" class="btn btn-outline-danger mx-1"><i class="fa fa-sign-out fa-fw"></i></button>
            </form>
        </div>
    </div>
</nav><br><br><br>
