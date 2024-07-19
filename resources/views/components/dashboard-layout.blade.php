<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Tableau de bord' }}</title>
        @vite(['resources/fonts/icomoon/style.css', 'resources/css/dashboard.css', 'resources/js/app.js'])
        
        @stack('dashboard-scripts')
        @stack('global-scripts')
    </head>
    <body class="dashboard">
        <header>
            <a href="{{ route('welcome') }}" class="header__logo">
                <img src="{{ Vite::asset('resources/images/logo.png') }}">
            </a>
            <nav>
                <ul>
                    <span class="divider"></span>
                    <li>
                        <a href="{{ route('dashboard') }}">Tableau de bord</a>
                    </li>
                    <li>
                        <a href="{{ route('ranges') }}">Gammes</a>
                    </li>
                    <li>
                        <a href="{{ route('products') }}">Produits</a>
                    </li>
                    <span class="divider"></span>
                    <li>
                        <a href="{{ route('productsFormats') }}">Formats de produits</a>
                    </li>
                    <span class="divider"></span>
                    <li>
                        <a href="{{ route('settings') }}">Paramètres</a>
                    </li>
                    <span class="divider"></span>
                </ul>
            </nav>
        </header>
        <div class="container">
            
            {{ $slot }}

        </div>
       
        <footer>
        </footer>

    </body>
</html>