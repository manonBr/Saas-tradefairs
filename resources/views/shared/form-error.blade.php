<x-layout>
    <x-slot:title>
        Eliquid France
    </x-slot>
   <div class="container landing--validation">
    <h1>OUPS</h1>
    <h2>Une erreur semble s'être produite</h2>

    <p>Veuillez vérifier que les informations ont été correctement enregistrées en téléchargeant le CSV et en vous rendant sur la page récapitulative :</p>

    <div><a href="/file/download/{{session('file')}}/{{session('route')}}/{{session('filename')}}" class="btn btn--primary">Télécharger le CSV</a></div>
    <div><a href="/{{session('route')}}" class="btn btn--primary">Se rendre sur le listing</a></div>
    <hr>
    <h3>Message d'erreur à transmettre au développeur :</h3>
    @if(session('error') && session('error') !== true)
        @include('shared.error', ['content' => session('error')])
    @endif
    </div>
</x-layout>