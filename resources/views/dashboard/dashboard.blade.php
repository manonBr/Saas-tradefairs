<x-dashboard-layout>
    <x-slot:title>
        Eliquid France | Tableau de bord
    </x-slot>
    <div class="content">
        <h1>Tableau de bord</h1>

        <div class="table__container">
            <h2>Produits activés non-créés en gestion</h2>
            @if(count($productsUnofficial) > 0)
                @foreach($productsUnofficial as $key => $format)
                <div>
                    <h3 onClick="toggleProducts(this)" class="toggle--title">
                        {{$ranges[$key]['range'] ?? 'Autre'}} | {{count($format)}} produit(s)
                        <span class="icon icon-circle-down"></span>
                    </h3>
                    <table class="table--minimalist hidden">
                        <tbody>
                            @foreach($format as $key => $item)
                                <tr>
                                    <td class="bold" width="200">{{$key}}</td>
                                    @foreach($item as $product)
                                        <td class="center">{{$product->nicotine}}mg/mL</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>    
                </div>
                @endforeach
            @else
                <p>Aucun produit non-créé en gestion</p>
            @endif
        </div>
    </div>
</x-dashboard-layout>