<x-dashboard-layout>
    <x-slot:title>
        Eliquid France | Tableau de bord
    </x-slot>
    <div class="content">
        <h1>{{$content['title']}}</h1>

        
        @if(session('error'))
            @include('shared.error', ['content' => session('error')])
        @endif
        @if(session('success'))
            @include('shared.success', ['content' => session('success')])
        @endif

        <div class="table__container">
            @include('components.dashboard.table-default', ['content' => $content, 'datas' => $datas, 'editable' => $editable])
        </div>

        
    </div>
</x-dashboard-layout>