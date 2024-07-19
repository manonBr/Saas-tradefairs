{{-- ARGUMENTS : [
    'name' [string], 
    'label' [string], 
    'caption' [string],
    'options' [array],
    'required'[bool],
    'initialData' [string]
    'dataset' [array]
    'onChange' [string]
] --}}

@isset($label)
    <label for="{{$name}}">{{$label}} {!! (isset($required) && $required) ? '<span class="required">*</span>' : '' !!}</label>
@endisset
<select name="{{$name}}" class="@error('{{$name}}') is-invalid @enderror" id="{{$name}}" {{ (isset($required) && $required) ? 'required' : ''}} onChange="{{$onChange ?? ''}}">
    <option value="">--{{$caption}}--</option>
    @foreach($options as $key => $option)
        <option value="{{($key === 'divide') ? '' : $key}}" {{(old($name) == $key) || (isset($initialData) && $initialData == $key) ? 'selected' : ''}} {{isset($dataset) ? ('data-'.$dataset['name'] . ' = "'.$dataset[$key].'"') : ''}}>{{$option}}</option>
    @endforeach
</select>

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror