@push('dashboard-scripts')
<script>
    window.addEventListener("load", (event) => {
        let selectedType = document.querySelector('#ranges_id')
        displayForm(selectedType)
    });
    
    const displayForm = (element) => {
        let typeName = element.options[element.selectedIndex].dataset.type
        let typeForm = document.querySelectorAll(`[data-id ~= ${typeName}]`)
        let formGroupToggles = document.querySelectorAll('.form__group__toggle')

        formGroupToggles.forEach((el) => {
            if(!el.classList.contains("hidden")) {
                el.classList.add("hidden")
            }
        })

        if(typeForm) {
            typeForm.forEach((el) => {
                if(el.classList.contains('hidden')) {
                    el.classList.remove("hidden")
                }
            })
        } 
    }

    const updateStatus = (element) => {
        element.parentNode.parentNode.querySelector('.switch__label[data-activate="' + element.checked + '"').classList.toggle('hidden')
        element.parentNode.parentNode.querySelector('.switch__label[data-activate="' + !element.checked + '"').classList.toggle('hidden')
    }
</script>
@endpush

<x-dashboard-layout>
    <x-slot:title>
        Eliquid France | Nouveau produit
    </x-slot>
   <div class="content">
        <h1>Ajout / modification produit</h1>

        @empty ($errors)
            @include('shared.error', ['content' => 'Une erreur est survenue !'])
        @endempty

        @if(session('error') && session('error') !== true)
            @include('shared.error', ['content' => session('error')])
        @endif
        <form action="{{!empty($product) ? route('product-update', ['id' => $product->id]) : route('product-add') }}" method="post" id='form' autocomplete="off">
            @csrf
            <div class="form__group switch__container flex--end">
                <span class="switch__label {{(!isset($product->active)  || (isset($product->active) && !$product->active)) ? 'hidden' : ''}}" data-activate="true">Activé</span>
                <span class="switch__label {{(isset($product->active) && $product->active) ? 'hidden' : ''}}" data-activate="false">Désactivé</span>
                <label class="switch">
                    <input type="checkbox" name="active" onChange="updateStatus(this)" {{(isset($product->active) && $product->active) ? 'checked' : ''}}>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="form__container">
            
                
                
                <fieldset>
                    <div class="form__group">
                        @include('components.form.input', ['type' => 'text', 'name' => 'name_shorten', 'label' => 'Nom du produit', 'placeholder' => 'ex : Red Pearl', 'defaultValue' => ($product->name_shorten ?? ''), 'required' => true])
                    </div>
                    <div class="form__group">
                        @include('components.form.input', ['type' => 'text', 'name' => 'name', 'label' => 'Intitulé complet du produit (semblable à celui présent dans EBP)', 'placeholder' => 'ex : Fruizee Red Pearl 0mg/ml de nicotine - Flacon de 10mL', 'defaultValue' => ($product->name ?? ''), 'required' => true, 'readonly' => (isset($product->name) ? true : false)])
                    </div>
                </fieldset>
                <div class="flex flex--spaceBetween">
                    <div class="flex__item">
                        <div class="form__group">
                            @include('components.form.select', ['name' => 'ranges_id', 'label' => 'Gamme', 'caption' => 'Veuillez choisir une gamme', 'options' => $ranges, 'initialData'=> ($product->ranges_id ?? ''), 'dataset' => $rangesDataset, 'required' => true, 'onChange' => "displayForm(this)"])  
                        </div>
                        <div class="form__group">
                            @include('components.form.select', ['name' => 'productType_id', 'label' => 'Catégorie de produit', 'caption' => 'Veuillez choisir une catégorie de produit', 'options' => $productTypes, 'initialData'=> ($product->productType_id ?? ''), 'required' => true])  
                        </div>
                        <span class="divider"></span>
                        <div class="form__group">
                            @include('components.form.input', ['type' => 'text', 'name' => 'code_art', 'label' => 'Code article', 'defaultValue' => ($product->code_art ?? ''), 'required' => true])
                        </div>
                        <div data-id="eliquide" class="form__group__toggle hidden">
                            <div class="form__group">
                                @include('components.form.select', ['name' => 'volumes_id', 'label' => 'Volume (mL)', 'caption' => 'Veuillez choisir un format', 'options' => $volumes, 'initialData'=> ($product->volumes_id ?? '')])  
                            </div>
                        </div>
                        <div data-id="eliquide pods" class="form__group__toggle hidden">    
                            <div class="form__group">
                                @include('components.form.select', ['name' => 'nicotines_id', 'label' => 'Nicotine (mg/mL)', 'caption' => 'Veuillez choisir un taux de nicotine', 'options' => $nicotines, 'initialData'=> ($product->nicotines_id ?? '')])  
                            </div>
                        </div>
                    </div>
                    <div class="flex_item">
                        <div class="form__group">
                            <label for="specificPrice">Prix spécifique</label>
                            <input type="number" name="specificPrice" id="specificPrice" value="{{ old('specificPrice') ?? $product->specificPrice ?? '0' }}" class="@error('specificPrice') is-invalid @enderror" step="0.01" required/>
                            @error('specificPrice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <button class="btn btn--secondary btn--form">Enregistrer</button>
                </div>
                <p><span class="required">*</span> Champs obligatoires</p>
            </div>
        </form>
    </div>
</x-dashboard-layout>