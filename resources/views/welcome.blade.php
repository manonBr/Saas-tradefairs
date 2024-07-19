<x-layout>
    <x-slot:title>
        Eliquid France | Salon
    </x-slot>
    <x-slot:welcome></x-slot>
    @if(session('validate_contact') && session('response') === true)
        <!-- REFACTOR :  -->
        @include('shared.success', ['content' => 'Le contact a bien été enregistré !'])
    @endif
    @if(session('response') && session('response') !== true)
        @include('shared.error', ['content' => session('response')])
    @endif
    <div class="container">
        <div class="welcome__nav">
            <a class="welcome__nav__item" href="{{ route('contact') }}">Contact</a>
            <a class="welcome__nav__item" href="{{ route('order') }}">Commande</a>
        </div>
    </div>
</x-layout>