/**
 * Helper : Update subtotal product when price update append
 * 
 * @param {Object} input 
 * @param {string|float} oldPrice 
 * @param {string|float} newPrice 
 */
window.updateProductSubtotal = (input, oldPrice, newPrice) => {
    const quantity = input.dataset.quantity
    const oldProductTotal = quantity * oldPrice
    const newProductTotal = quantity * newPrice
    const productSubtotal = input.closest('tr').querySelector(".subTotal")

    productSubtotal.innerText = Math.round(((parseFloat(productSubtotal.innerText) - oldProductTotal) + newProductTotal) * 100) / 100
}

/**
 * Helper : recalculate range and order totals
 * 
 * @param {Object} element 
 */
window.updateTotals = (element) => {
    calculateTotalRange(element.closest('.orderRange'))
    calculateTotal()
}

/**
 * Run all actions to update price of a specific range format
 * 
 * @param {Object} element 
 */
window.updateRangeFormatPrice = (element) => {
    const container = element.parentElement
    
    toggleFormUpdateRangeFormatPrice(container)
    container.querySelector('.form-newPrice .btn').addEventListener("click", function(e) {
        e.preventDefault()
        const volume = element.dataset.columnvolume
        const newPrice = ((e.target.previousElementSibling.value >= 0)? (e.target.previousElementSibling.value) : 0)
        
        replacePriceValueInRange(element, volume, newPrice)
        toggleFormUpdateRangeFormatPrice(container)
    }, { once: true })
}

window.toggleFormUpdateRangeFormatPrice = (container) => {
    container.querySelector('.form-newPrice').classList.toggle('hidden')
    container.querySelector('.tableOrderEditBtn').classList.toggle('flex-visible')
}

window.replacePriceValueInRange = (element, volume, newPrice) => {
    const oldPrice = element.parentElement.querySelector('.currenPrice__price ').textContent
    const inputsToUpdate = element.closest('table').querySelectorAll('[data-volume="'+volume+'"]')
    element.parentElement.querySelector('.currenPrice__price ').textContent = newPrice
 
    inputsToUpdate.forEach((input) => {
        if(input.dataset.price == oldPrice) {
            input.dataset.price = newPrice
            if(input.value > 0) {
                updateProductSubtotal(input, oldPrice, newPrice) 
            }
        }
    })

    updateTotals(element)
}

/**
 * Run all actions to update price of a specific product format
 * 
 * @param {Object} element 
 */
window.updateProductFormatPrice = (element) => {
    const rangeId = element.dataset.rangeid
    const popup = element.closest('table').nextElementSibling
    const inputs = new Array()
    popup.querySelectorAll('input').forEach((input) => {
        inputs.push({
            'type' : input.dataset.type,
            'volume' : input.dataset.volume,
            'price' : input.value
        })
    })
    
    toggleFormUpdateProductFormatPrice(element)

    popup.querySelector('.btn').addEventListener("click", function(e) {
        e.preventDefault()
        
        inputs.forEach( inputOriginalDatas => {
            const currentInput = popup.querySelector(`input[data-volume='${inputOriginalDatas.volume}']`)
            const newPrice = currentInput.value
            replacePriceValueForProduct(element, currentInput, newPrice)
        })

        toggleFormUpdateProductFormatPrice(element)
    }, { once: true })
}

window.toggleFormUpdateProductFormatPrice = (element) => {
    element.closest('table').nextElementSibling.classList.toggle('hidden')
}

window.replacePriceValueForProduct = (element, currentInput, newPrice) => {
    const volume = currentInput.dataset.volume
    const type = currentInput.dataset.type
    const elementRow = element.closest('th')
    const datasetTypeVolume = `[data-volume="${volume}"][data-type="${type}"]`
    const oldPrice = element.closest('tr').querySelector(`input${datasetTypeVolume}`).dataset.price

    if(oldPrice !== newPrice) {
        const inputsToUpdate = element.closest('tr').querySelectorAll(`input${datasetTypeVolume}`)
        
        if(!elementRow.querySelector(`.order__specificPrice span${datasetTypeVolume} .price`)) {
            const currency = currentInput.dataset.currency
            const htmlNode = `(<span class="small" data-volume="${volume}" data-type="${type}">${type}-${volume}mL : <span class="price"></span>${currency}</span>)`

            elementRow.querySelector('.order__specificPrice').insertAdjacentHTML( 'beforeend', htmlNode );
        } 

        elementRow.querySelector(`.order__specificPrice span${datasetTypeVolume} .price`).textContent = newPrice
        
        inputsToUpdate.forEach(input => {
            input.dataset.price = newPrice
            input.closest
            input.closest('td').classList.add('has--specificPrice')
            if(input.value > 0) {
                updateProductSubtotal(input, oldPrice, newPrice)    
            }
        })
    
        updateTotals(element)
    }
}

window.resetProductPrices = (element) => {
    const popup = element.closest('.updateProductFormatPrice')
    popup.querySelectorAll('input').forEach( input => {
        const initialPrice = input.previousElementSibling.querySelector('.initialPrice').textContent
        input.value = initialPrice
    })
}