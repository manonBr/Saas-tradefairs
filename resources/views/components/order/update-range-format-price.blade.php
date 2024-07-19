<span class="tableOrderEditBtn" data-quantity="{{count($dataproducts)}}" data-columnVolume="{{$volume}}" onClick="updateRangeFormatPrice(this)"><span class="icon-pencil"></span></span>

<div class="form-newPrice hidden" id="{{$rangeId}}">
    <input type="number" name="formatPrice-{{$rangeId}}" class="{{$volume}}-newPrice" value="{{$datas['prices'][$type . $volume]}}" min="0" form="form-newPrice"/>
    <button class="btn btn--small btn--inline btn--primary" form="form-newPrice">Modifier</button>
</div>