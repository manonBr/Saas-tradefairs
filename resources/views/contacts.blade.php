<x-layout>
    <x-slot:title>
        Eliquid France | Liste des contacts
    </x-slot>
    <div class="container">
        <h1>Liste des contacts</h1>

        @if(session('response') == true)
            @include('shared.success', ['content' => 'Action effectuée avec succès !'])
        @elseif(session('response') === false)
            @include('shared.error', ['content' => 'L\'action n\'a pas pu être effectuée !'])
        @endif

        @if(count($contacts) > 0)
            <div class="group__btn">
                <form action="{{ route('contacts-delete') }}" method="POST" onSubmit="return displayConfirmModal()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--alert"><span class="icon-bin"></span> Tout supprimer</button>
                </form>
                <form action="{{ route('contacts-download') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn--primary">Télécharger l'ensemble des contacts</button>
                </form>
            </div>
        @endif

        <p> {{count($contacts)}} contacts enregistré(s)</p>
        <table with="100" class='table--firstColumnFull'>
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Fonction</th>
                    <th>Notes</th>
                    <th width="70" colspan="2"></th>
                </tr>
            </thead>
                @if(count($contacts) !== 0)
                <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                        <td>{{$contact->company}}</td>
                        <td>{{$contact->lastname}}</td>
                        <td>{{$contact->firstname}}</td>
                        <td>{{$contact->function}}</td>
                        <td>{{$contact->notes}}</td>
                        <td class="center">
                            <a href="/file/download/csv/contacts/{{$contact->csvToken}}" class="btn btn--light"><span class="icon-download3"></span></a>
                        </td>
                        <td class="center">
                            <form action="{{ route('contact-delete', $contact->id) }}" method="POST"  onSubmit="return displayConfirmModal()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--alert btn--light"><span class="icon-bin"></span></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @else
                <tbody>
                    <tr align="center">
                        <td colspan="7">Aucun contact enregistré
                    </tr>
                </tbody>
            @endif
        </table>
    </div>
</x-layout>
