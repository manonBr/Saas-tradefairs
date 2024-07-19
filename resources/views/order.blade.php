@push('child-scripts')
    <script>
        const getValue = (e) => {
            const value = e.target.value
            const dataSelected = document.querySelector(`option[value="${value}"]`)
            const inputHidden = document.querySelector('#customerId')
            const selectedCustomerDisplay = document.querySelector('#selectedCustomer')
            const form = document.querySelector('#orderForm')
            const message = document.querySelector('#orderWaitingMessage')

            if(dataSelected) {
                inputHidden.setAttribute('value', dataSelected.dataset.id)
                selectedCustomerDisplay.textContent = value
                form.classList.remove('hidden')
                message.classList.add('hidden')
            } else {
                inputHidden.setAttribute('value', '')
                selectedCustomerDisplay.textContent = ''
                form.classList.add('hidden')
                message.classList.remove('hidden')
                alert('Client non trouvé. Veuillez rafraichir la page et réessayer')
            }
        }

        const simulateAnchor = (id) => {
            if(document.getElementById(id).nextElementSibling.classList.contains("hidden")) {
                toggleProducts(document.getElementById(id))
            }
            let link = document.querySelector(`[data-click = '${id}']`)
            link.click()

        }

        const calculateTotal = () => {
            const subTotals = document.querySelectorAll('.subTotal')
            let total = 0
            subTotals.forEach((subTotal) => {
                total += parseFloat(subTotal.innerText)
            })
            document.querySelector('#total').value = Math.round(total*100)/100
        }

        const calculateTotalRange = (parent) => {
            const totalItem = parent.querySelector('.orderRange__total')
            const subTotals = parent.querySelectorAll('.subTotal')
            const currency = @json(setting('settings')->get('currency', '€'))

            let total = 0
            subTotals.forEach((subTotal) => {
                total += parseFloat(subTotal.innerText)
            })
            if(total == 0){
                totalItem.innerText = ''
                return;
            }
            totalItem.innerHTML = '(' + Math.round(total*100)/100 + '<span class="currency">'+ currency +'</span>)'

        }

        const calculatesubTotal = (event) => {
            const id = event.target.dataset.id
            
            if(event.target.getAttribute('name') === `products[${id}]`){
                
                const subTotal = event.target.parentNode.parentNode.querySelector(".subTotal")

                const oldQuantity = event.target.dataset.quantity
                const newQuantity = event.target.value
                let realQuantity = newQuantity - oldQuantity

                event.target.dataset.quantity = newQuantity

                const price = event.target.dataset.price ?? 0
                const total = realQuantity * price
                
                subTotal.innerText = Math.round((parseFloat(subTotal.innerText) + parseFloat(total))*100)/100


                calculateTotalRange(event.target.closest('.orderRange'))
                calculateTotal()
            }

            event.stopPropagation() // Stop the event from bubbling up
        }

        window.addEventListener("DOMContentLoaded", function() {
            document.getElementById("orderContainer").addEventListener("click", calculatesubTotal )
            document.getElementById("orderContainer").addEventListener("keyup", calculatesubTotal )
        })

        const toggleOrderNav = (element) => {
            element.parentElement.classList.toggle("open")
            element.classList.toggle("icon-menu")
            element.classList.toggle("icon-cross")
        }
    </script>
@endpush


@push('child-import-scripts')
    <script src="{{ Vite::asset('resources/js/update-price-in-order.js') }}"></script>
    <!-- <script src="{{ asset('/resources/js/update-price-in-order.js')}}"></script> -->
@endpush

<x-layout>
    <x-slot:title>
        Eliquid France | Pris de commande
    </x-slot>
   <div class="container" id="order">
    <h1>Prise de commande</h1>

    @error('products')
        @include('shared.error', ['content' => $message])
    @enderror

    <div id="orderWaitingMessage">
        <div class="customerSelection">
            <div class="customerSelection__item">
                <a href="{{ route('contact') }}" class="btn btn--primary">Créer une fiche contact</a>
            </div>
            <div class="customerSelection__item">
                <span>OU</span>
            </div>
            <div class="customerSelection__item">
                @if(empty($customers))
                    Aucune fiche contact existante
                @endif
                <input type="text" list="customers" id="customersInput" onchange='getValue(event)' placeholder="Sélectionner un client" {!!empty($customers) ? "readonly='true'" : '' !!}>

                <datalist id="customers">
                    @foreach($customers as $customer)
                        <option value="{{$customer['lastname']}} - {{$customer['company']}} - {{$customer['email']}}" data-id="{{$customer['id']}}">{{$customer['lastname']}} - {{$customer['company']}} - {{$customer['email']}}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <p class="italic">Assurez-vous de sélectionner la bonne fiche client avant toute saisie de commande</p>
    </div>

    <form action="{{ route('order-add') }}" method="post" id='orderForm' class="hidden">
        @csrf
        <p id="selectedCustomer__wrap">Client sélectionné : <span id="selectedCustomer"></span></p>
        <input type="hidden" id="customerId" name="customerId">

        <div class="orderNav">
            @foreach($ranges as $range)
                <a onClick="simulateAnchor({{$range['id']}})">{{$range['range']}}</a>
                <a class="hidden" href="#{{$range['id']}}" data-click="{{$range['id']}}">{{$range['range']}}</a>
            @endforeach
            <span class="icon icon-menu" onClick='toggleOrderNav(this)'></span>
        </div>
        <div id="orderContainer">
            @foreach($products as $keyrange => $range)
                @php($rangeId = $ranges[$keyrange]['id'])
                <div class="orderRange">
                    <h2 onClick="toggleProducts(this)" id="{{$rangeId}}">
                        {{$ranges[$keyrange]['range'] ?? 'Autre'}} 
                        <span class="icon icon-circle-down"></span>
                        <span class="orderRange__total"></span>
                    </h2>

                    <div class="orderRange__container hidden">
                        @if($ranges[$keyrange]['type_name'] === 'diy' || $ranges[$keyrange]['type_name'] === 'eliquide' || $ranges[$keyrange]['type_name'] === 'pods')

                            @include('components.order.table-eliquide', [
                                'rangeId' => $rangeId, 
                                'products'  => $range, 
                                'datas'     => $datas[$rangeId]
                            ])
                                
                        @else

                            @include('components.order.table-default', [
                                'rangeId' => $rangeId,
                                'products' => $range 
                            ])

                        @endif
                    </div>
                    
                </div>
            @endforeach
        </div>

        <div>
            <label for="notes">Notes</label>
            <textarea id="notes" name="notes" rows="7" class="@error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <fieldset>
                <legend>Total de la commande (en {{setting('settings')->get('currency', '€')}})</legend>
                <input type="text" name="total" id="total" value="0" class="@error('total') is-invalid @enderror" required readonly="true"/>
                @error('total')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </fieldset>
        </div>

        <div>
            <button class="btn btn--primary btn--form">Commander</button>
        </div>
    </form>
    </div>
</x-layout>