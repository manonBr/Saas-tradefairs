<table class='table--firstColumnFull'>
    <thead>
        <tr>
            <th width="250"></th>
            <th>Quantité</th>
            <th width="50">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $key => $product)
        <tr>
            <td>
                {{$key}}
                @if($product['material']['0']['0']->specificPrice != 0)
                    (<span class="small">{{$product['material']['0']['0']->specificPrice . setting('settings')->get('currency', '€')}}</span>)
                @endisset
            </td>
            <td>@isset($product['material']['0']['0']->id)<input type="number" name="products[{{$product['material']['0']['0']->id}}]" data-id="{{$product['material']['0']['0']->id}}" data-price="{{($product['material']['0']['0']->specificPrice != 0) ? $product['material']['0']['0']->specificPrice : '0'}}" data-quantity="0" min="0" step="1">@endisset</td>
            <td><span class="subTotal">0</span>{{setting('settings')->get('currency', '€')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>