<table class='table--firstColumnFull'>
    <thead>
        <tr>
            <th width="150" rowspan="2"></th>
            @foreach($datas['productTypes'] as $type => $data)
                @foreach($data as $volume => $dataproducts)                
                    <th colspan='{{count($dataproducts)}}' class="orderCellHead">
                        {{$datas['contentTableHead'][$type][$volume]}}<br>
                        @isset($datas['prices'][$type . $volume])
                            <span class="currentPrice small"><span class="currenPrice__price">{{$datas['prices'][$type . $volume]}}</span> {{setting('settings')->get('currency', '€')}}</span>
                            <x-order.update-range-format-price :$dataproducts :$datas :$rangeId :$volume :$type></x-order.update-range-format-price>
                        @endisset
                    </th>
                @endforeach 
            @endforeach
            <th width="50" rowspan="2">Total</th>
        </tr>
        <tr>
            @foreach(array_merge(...array_values($datas['nicotines'])) as $nicotine)
                    <th>{{$nicotine}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($products as $key => $product)
            <tr>
                <th>
                    <span class="updateProductPriceBtn" data-rangeid="{{$rangeId}}" onClick="updateProductFormatPrice(this)"><span class="icon-pencil"></span></span>
                    <span class='bold'>{{$key}}</span><br>
                    <div class='order__specificPrice'>
                        @if(isset($datas['specificPrices']) && isset($datas['specificPrices'][$key]))
                        @foreach($datas['specificPrices'][$key] as $type => $data)
                        
                        @foreach($data as $volume => $specificPrice)
                        (<span class="small" data-volume="{{$volume}}" data-type="{{$type}}">{!!$type !== 'diy' ? $type : ''!!}-{{$volume}}mL : <span class="price">{{$specificPrice}}</span>{{setting('settings')->get('currency', '€')}}</span>)<br>
                        @endforeach
                        @endforeach
                        @endif
                    </div>
                </th>
                @foreach($datas['products'] as $item)
                <td>@isset($product[$item['type']][$item['volume']][$item['nicotine']]->id)
                            <input 
                                type="number" 
                                name="products[{{$product[$item['type']][$item['volume']][$item['nicotine']]->id}}]" 
                                data-id="{{$product[$item['type']][$item['volume']][$item['nicotine']]->id}}" 
                                data-price="{{($product[$item['type']][$item['volume']][$item['nicotine']]->specificPrice != 0) ? $product[$item['type']][$item['volume']][$item['nicotine']]->specificPrice : ($datas['prices'][$item['type'] . $item['volume']] ?? '0')}}" 
                                data-quantity="0"
                                data-type="{{$item['type']}}" 
                                data-volume="{{$item['volume']}}" 
                                min="0" 
                                step="{{$item['volume'] == '10' ? '5' : '1'}}">
                        @endisset</td>
                @endforeach
                <td><span class="subTotal">0</span>{{setting('settings')->get('currency', '€')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<x-order.update-product-format-price :$datas :$product :$item></x-order.update-product-format-price>

