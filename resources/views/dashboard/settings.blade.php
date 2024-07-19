<x-dashboard-layout>
    <x-slot:title>
        Eliquid France | Tableau de bord
    </x-slot>
    <div class="content">
        <h1>Paramètres</h1>

        @if(session('error'))
            @include('shared.error', ['content' => session('error')])
        @endif
        @if(session('success'))
            @include('shared.success', ['content' => session('success')])
        @endif
        
        <div id="currency">
            <form action="{{ route('settings-currency-update') }}" method="post" id='form' class="form--inline">
                @csrf
                @include('components.form.select', ['name' => 'currency', 'label' => 'Devise', 'caption' => 'Veuillez sélectionner une devise', 'options' => $currencies, 'required' => true, 'initialData' => setting('settings')->get('currency', '€')])
                <button class="btn btn--primary">Enregistrer</button>
            </form>
        </div>
        
        <span class="divider divider--big"></span>

        @foreach($tables as $table)
            <div class="table__container">
                <h2>{{$table['content']['title']}}</h2>
                @include('components.dashboard.table-default', ['content' => $table['content'], 'datas' => $table['datas'], 'editable' => $table['editable']])
            </div>
        @endforeach
    </div>
</x-dashboard-layout>