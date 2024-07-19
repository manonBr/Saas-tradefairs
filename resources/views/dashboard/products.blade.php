<x-dashboard-layout>
    <x-slot:title>
        Eliquid France | Tableau de bord
    </x-slot>
    <div class="content products">
        <h1>Gestion des produits</h1>

        
        @if(session('error'))
            @include('shared.error', ['content' => session('error')])
        @endif

        @if(session('success'))
            @include('shared.success', ['content' => (session('success') ?? "Produit(s) ajouté(s) avec succès")])
        @endif

        <div>
            <form action="{{ route('products-upload') }}" class="form--inline" method="post" id='form' enctype="multipart/form-data">
                @csrf
                <div>
                    <input type="file" accept=".csv" name="products" id="products" value="{{ old('products') }}" class="@error('products') is-invalid @enderror" required/>
                    @error('products')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button class="btn btn--primary">Importer*</button>
            </form>
            <span class="input__legend">* Fichier .csv uniquement(Colonnes : Code article, Libellé)</span>
        </div>
        <div class="group__btn">
            <a href="{{ route('product-form') }}" class="btn btn--primary">Ajouter un nouvel article</a>
            <form action="{{ route('products-delete') }}" method="POST" onSubmit="return displayConfirmModal()">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--alert"><span class="icon-bin"></span> Tout supprimer</button>
            </form>
        </div>

        @if($products)
            @foreach($products as $key => $product)
                <div class="products__item table__container" id="range-{{$ranges[$key]['id']}}">
                    <h2 onClick="toggleProducts(this)">
                        {{$ranges[$key]['range'] ?? 'Autre'}}
                        <span class="icon icon-circle-down"></span>
                    </h2>
                    <table with="100" class="hidden">
                        <thead>
                            <tr>
                                <th>Actif</th>
                                <th>Nom</th>
                                <th>Code article</th>
                                <th>Volume</th>
                                <th>Taux de nicotine</th>
                                <th colspan="2" width="50"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product as $item)
                                <tr id="range-{{$item->id}}">
                                    <td>
                                        <form action="{{ route('product-updateStatus', [$item->id, ($item->active ? $item->active : 0)]) }}" method="POST" onSubmit="return updateStatusAjaxRequest(event, this, {{$item->id}})">
                                            @csrf
                                            <button type="submit" class="btn {{$item->active ? 'btn--success' : 'btn--alert'}} btn--light">
                                                {!!$item->active ? '<span class="icon-checkmark"></span>' : '<span class="icon-cross"></span>'!!}
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{$item->name_shorten}}</td>
                                    <td>{{$item->code_art}}</td>
                                    <td>{{$item->volume}}</td>
                                    <td>{{$item->nicotine}}</td>
                                    <td class="center">
                                        <a href="{{ route('product-form', $item->id) }}" class="btn btn--primary btn--light"><span class="icon-pencil"></span></button>
                                    </td>
                                    <td class="center">
                                        <form action="{{ route('product-delete', $item->id) }}" method="POST"  onSubmit="return displayConfirmModal()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn--alert btn--light"><span class="icon-bin"></span></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endif
    </div>
</x-dashboard-layout>