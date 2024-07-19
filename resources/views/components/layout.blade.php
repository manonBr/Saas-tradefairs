<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Todo Manager' }}</title>
        @vite(['resources/fonts/icomoon/style.css', 'resources/css/app.css', 'resources/js/app.js'])
        
        @stack('child-scripts')
        @stack('child-import-scripts')
        @stack('global-scripts')
    </head>
    <body>
        <header class="{{ isset($welcome) ? 'header--welcome' : 'header' }}">
            <a href="{{ route('welcome') }}" class="header__logo">
                <img src="{{ Vite::asset('resources/images/logo.png') }}">
            </a>
            @empty($welcome)
            <nav class="header__nav">
                <ul class="nav">
                    <li class="nav__item"><a href="{{ route('welcome') }}">Accueil</a></li>
                    <li class="nav__item"><a href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav__item"><a href="{{ route('order') }}">Commande</a></li>
                </ul>
            </nav>
            @endempty
        </header>
       
        {{ $slot }}

        <footer class="footer {{ isset($welcome) ? 'footer--welcome' : '' }}">
            <div class="footer__nav">
                <a class="footer__nav__item" href="{{ route('contacts') }}">Tous les contacts</a>
                <a class="footer__nav__item" href="{{ route('orders') }}">Toutes les commandes</a>
            </div>
        </footer>

    </body>
</html>