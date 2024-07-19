<div class="popup updateProductFormatPrice hidden">
    <span class="icon-cross close" onclick="closeModal(this)"></span>
    <h2>Modification d'un tarif produit</h2>
    @foreach($datas['productTypes'] as $type => $data)
        @foreach($data as $volume => $dataproducts)               
                @isset($datas['prices'][$type . $volume])
                    <div>
                        <label for="{{$product[$item['type']][$item['volume']][$item['nicotine']]->id}}-productVolume[{{$volume}}]">{{$datas['contentTableHead'][$type][$volume]}} (en {{setting('settings')->get('currency', '€')}}) -- <span class="initialPrice">{{$datas['prices'][$type . $volume]}}</span> {{setting('settings')->get('currency', '€')}}</label>
                        <input 
                            type="number" 
                            name="{{$product[$item['type']][$item['volume']][$item['nicotine']]->id}}-productVolume" 
                            value="{{$datas['prices'][$type . $volume]}}"
                            data-volume="{{$datas['contentTableHead'][$type]['volume']}}"
                            data-type="{{$datas['contentTableHead'][$type]['type']}}"
                            data-currency="{{setting('settings')->get('currency', '€')}}"
                            min="0" 
                            step="0.01"
                            form="form-newProductPrice">
                    </div>
                @endisset
        @endforeach 
    @endforeach
    <button class="btn btn--form btn--primary" form="form-newProductPrice">Modifier</button>
    <a href="#" onclick="resetProductPrices(this)">Réinitialiser</a>
</div>