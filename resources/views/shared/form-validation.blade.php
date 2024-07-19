<x-layout>
    <x-slot:title>
        Eliquid France | Félicitation
    </x-slot>
   <div class="container landing--validation">
    <h2>Les informations ont été bien enregistrées.</h2>

    <p>Vous retrouverez toutes ces informations sur la page récapitulative ou en téléchargeant le fichier CSV en cliquant sur le bouton ci-dessous :</p>

    <div><a href="/file/download/{{session('file')}}/{{session('route')}}/{{session('filename')}}" class="btn btn--primary">Télécharger le CSV</a></div>
    </div>
</x-layout>