{{-- Accueil du client (template : index.html) --}}
{{-- Affiche la dernière notification de la banque, un carousel et les raccourcis vers les autres pages --}}
@extends('layouts.client')

@section('title', 'Home')

@section('contenu')
<div class="row w-100">
    {{-- Colonne de gauche : message de bienvenue + carousel --}}
    <div class="col" style="padding: 22px;padding-top: 0">
        <div class="jumbotron shadowBlack" style="padding: 25px;min-height: 241px;max-height: 241px">
            <h4 class="display-5">Welcome to MCB Bank, {{ $account->name }}</h4>
            <p class="lead alert alert-warning"><b>Latest Notification:</b>
                {{-- dernière notification envoyée par le manager --}}
                @if ($lastNotice)
                    {{ \Illuminate\Support\Str::limit($lastNotice->notice, 120) }}
                @else
                    No notification for now.
                @endif
            </p>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide my-2 rounded-1 shadowBlack" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('frontend/images/1.jpg') }}" alt="First slide" style="max-height: 250px">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('frontend/images/2.jpg') }}" alt="Second slide" style="max-height: 250px">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('frontend/images/3.jpg') }}" alt="Third slide" style="max-height: 250px">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    {{-- Colonne de droite : 4 cartes de raccourcis --}}
    <div class="col">
        <div class="row" style="padding: 22px;padding-top: 0">
            <div class="col">
                <div class="card shadowBlack">
                    <img class="card-img-top" src="{{ asset('frontend/images/acount.jpg') }}" style="max-height: 155px;min-height: 155px" alt="">
                    <div class="card-body">
                        <a href="{{ url('/accounts') }}" class="btn btn-outline-success btn-block">Account Summary</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadowBlack">
                    <img class="card-img-top" src="{{ asset('frontend/images/transfer.jpg') }}" alt="" style="max-height: 155px;min-height: 155px">
                    <div class="card-body">
                        <a href="{{ url('/transfer') }}" class="btn btn-outline-success btn-block">Transfer Money</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 22px">
            <div class="col">
                <div class="card shadowBlack">
                    <img class="card-img-top" src="{{ asset('frontend/images/bell.gif') }}" style="max-height: 155px;min-height: 155px" alt="">
                    <div class="card-body">
                        <a href="{{ url('/notice') }}" class="btn btn-outline-primary btn-block">Check Notification</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadowBlack">
                    <img class="card-img-top" src="{{ asset('frontend/images/contacts.gif') }}" alt="" style="max-height: 155px;min-height: 155px">
                    <div class="card-body">
                        <a href="{{ url('/feedback') }}" class="btn btn-outline-primary btn-block">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
