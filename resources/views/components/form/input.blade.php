@isset($type)
    @if($type === 'radio')
        {{-- ARGUMENTS : [
            'type' [string], 
            'name' [string], 
            'value' [string], 
            'label' [string], 
            'required' [bool], 
            'checked' [bool]
        ] --}}
        <input type="radio" id="{{$value}}" name="{{$name}}" value="{{$value}}" {{ (old($name) == $value) ? 'checked' : ((isset($checked) && $checked) ? 'checked' : '')}} {{ (isset($required) && $required) ? 'required' : ''}}/>
        @isset($label)
            <label for="{{$name}}">{{$label}}</label>
        @endisset

    @elseif($type === 'checkbox')
        {{-- ARGUMENTS : [
            'type' [string], 
            'name' [string], 
            'value' [string], 
            'label' [string]
        ] --}}
        <input type="checkbox" id="{{$name}}" name="{{$name}}" value="{{$value ?? ''}}" {{ old($name) === $value ? 'checked' : '' }}/>
        @isset($label)
            <label for="{{$name}}">{{$label}}</label>
        @endisset


    @elseif($type === 'number')
        <!-- INPUT : NUMBER (DEFAULT STEP = 1) -->
        @isset($label)
            <label for="{{$name}}">{{$label}} {!! (isset($required) && $required) ? '<span class="required">*</span>' : '' !!}</label>
        @endisset
        <input type="number" name="{{$name}}" id="{{$name}}" value="{{ old('$name') ?? $product->specificPrice ?? '0' }}" class="@error('{{$name}}') is-invalid @enderror" step="{{$step ?? '0.01'}}" {{ (isset($required) && $required) ? 'required' : ''}}/>
        @error('{{$name}}')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror


    @elseif($type === 'file')
        <!-- INPUT : FILE -->
        <input type="file" accept=".csv" name="{{$name}}" id="{{$name}}" value="{{ old('$name') }}" class="@error('{{$name}}') is-invalid @enderror" {{ (isset($required) && $required) ? 'required' : ''}}/>
        @error('{{$name}}')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    @elseif($type === 'text' || $type === 'tel' || $type === 'email')
        {{-- ARGUMENTS : [
            'type' [string], 
            'name' [string], 
            'label' [string], 
            'placeholder' [string], 
            'required' [bool], 
            'defaultValue' [string]
        ] --}}

        @isset($label)
            <label for="{{$name}}">{{$label}} {!! (isset($required) && $required) ? '<span class="required">*</span>' : '' !!}</label>
        @endisset
        <input type="{{$type}}" name="{{$name}}" id="{{$name}}" value="{{isset($defaultValue) ? $defaultValue : (old($name) ?? '')}}" class="@error($name) is-invalid @enderror" {{ (isset($required) && $required) ? 'required' : ''}} {{ (isset($readonly) && $readonly) ? 'readonly="true"' : ''}} placeholder="{{$placeholder ?? ''}}"/>
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        
    @endif
@endisset
