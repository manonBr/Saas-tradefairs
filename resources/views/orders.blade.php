<x-layout>
    <x-slot:title>
        Eliquid France | Commandes
    </x-slot>
    <div class="container">
        <h1>Liste des commandes</h1>

        @if(session('response') == true)
            @include('shared.success', ['content' => 'Action effectuée avec succès !'])
        @elseif(session('response') === false)
            @include('shared.error', ['content' => 'L\'action n\'a pas pu être effectuée !'])
        @endif
        @if(session('error') && session('error') !== true)
            @include('shared.error', ['content' => session('error')])
        @endif

        @if(count($orders) > 0)
            <div class="group__btn">
                <form action="{{ route('orders-delete') }}" method="POST" onSubmit="return displayConfirmModal()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--alert"><span class="icon-bin"></span> Tout supprimer</button>
                </form>
                <form action="{{ route('orders-download') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn--primary">Télécharger l'ensemble des commandes</button>
                </form>
            </div>
        @endif

        <p> {{count($orders)}} commandes enregistré(s)</p>
        <table with="100">
            <thead>
                <tr>
                    <th width="30">#ID</th>
                    <th>Client</th>
                    <th>Produits achetés</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th width="70" colspan="2"></th>
                </tr>
            </thead>
            @if(count($orders) !== 0)
                <tbody>
                    @foreach($orders as $key => $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order['customer']->company}} - {{$order['customer']->firstname}} {{$order['customer']->lastname}}</td>
                        <td>
                            <ul>
                                @foreach($order['items'] as $product)
                                    <li>{{$product->name}} - x{{$product->quantity}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$order['total'] . setting('settings')->get('currency', '€')}}</td>
                        <td>{{$order['created_at']->format('d-m-Y')}}</td>
                        <td class="center">
                            @if(!empty($order->csvToken))
                                <a href="/file/download/csv/orders/{{str_replace(' ', '_', 'Commande '. $order->id . ' - ' . $order['customer']->company).'-'.$order->csvToken}}" class="btn btn--light"><span class="icon-download3"></span></a>
                            @endif
                        </td>
                        <td class="center">
                            <form action="{{ route('orders-delete', $order->id) }}" method="POST"  onSubmit="return displayConfirmModal()">
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
                        <td colspan="7">Aucune commande enregistrée
                    </tr>
                </tbody>
            @endif
        </table>
    </div>



        
    
</x-layout>