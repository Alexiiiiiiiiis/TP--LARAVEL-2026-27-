<!DOCTYPE html>
{{-- Layout de base commun à toutes les pages du site MCB Bank --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Titre de l'onglet : chaque page définit sa section "title" --}}
    <title>@yield('title') - MCB Bank</title>
    <link rel="shortcut icon" href="{{ asset('frontend/images/logo.png') }}">

    {{-- CSS : Bootstrap, styles du template et icônes Font Awesome --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/font-awesome/css/font-awesome.min.css') }}">

    {{-- JS : jQuery, Popper et Bootstrap (nécessaires pour le menu, les modals et le carousel) --}}
    <script src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        // active les infobulles (tooltips) de Bootstrap
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
</head>

{{-- Le fond peut être changé par une page (ex : la page de connexion) --}}
<body style="@yield('body_style', 'background:#96D678;background-size: 100%')">

    {{-- Barre de navigation : définie par le layout de chaque espace (client, manager, caissier) --}}
    @yield('navbar')

    {{-- Contenu de la page --}}
    @yield('contenu')

</body>

</html>
