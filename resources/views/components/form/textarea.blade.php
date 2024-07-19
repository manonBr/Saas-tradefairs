<!-- ARGUMENTS : [
    'name' [string], 
    'label' [string], 
    'rows' [int]
] -->

@isset($label)
    <label for="{{$name}}">{{$label}}</label>
@endisset
<textarea id="{{$name}}" name="{{$name}}" rows="{{$rows}}" class="@error($name) is-invalid @enderror">{{ old($name) }}</textarea>
@error($name)
<div class="invalid-feedback">{{ $message }}</div>
@enderror