window.displayConfirmModal = function() {
    let validation = confirm("Êtes-vous sûr de vouloir faire cela ?");
    if (validation) {
        return true;
    }
    else {
        return false;
    }
}

window.closeModal = function(element) {
    element.parentElement.classList.add('hidden')
}

window.toggleProducts = function(element) {
    element.nextElementSibling.classList.toggle("hidden")
    element.children[0].classList.toggle("icon-circle-down")
    element.children[0].classList.toggle("icon-circle-up")
}

window.ajaxRequest = function(e, element) {
    e.preventDefault()

    const form = element 
    const datas = new FormData(form)
    const ajaxUrl = form.action
    const formName = form.dataset.formname

    fetch(ajaxUrl, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': datas.get('_token')
        }
    })
    .then(function(response) {
        return response.json();
    }).then(function(json) {
        const form = document.querySelector(`#${formName}`)
        form.parentNode.classList.remove('hidden')

        for (const [key, value] of Object.entries(json)) {
            if(
                form.querySelector(`input[name="${key}"]`) &&
                form.querySelector(`input[name="${key}"]`).type != 'checkbox'
            ) {
                form.querySelector(`input[name="${key}"]`).value = value
            }
            if(form.querySelector(`select[name="${key}"]`)) {
                form.querySelector(`select[name="${key}"] option[value="${value}"]`).selected = true
            }
            if(form.querySelector(`input[type="checkbox"][name="${key}"]`)) {
                form.querySelector(`input[type="checkbox"][name="${key}"]`).checked = value
            }
        }
    })
    .catch(function(error){
        console.error(error)
    }) 
}

window.updateStatusAjaxRequest = function(e, element, id) {
    e.preventDefault()

    const form = element 
    const datas = new FormData(form)
    let ajaxUrl = form.action
    const currentStatus = !!Number(ajaxUrl.split('/').pop())

    fetch(ajaxUrl, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': datas.get('_token')
        }
    })
    .then(function(response) {
        return response.json();
    }).then(function(json) {
        const newStatus = currentStatus ? 0 : 1
        form.querySelector('span').classList.toggle('icon-checkmark')
        form.querySelector('span').classList.toggle('icon-cross')
        form.querySelector('button.btn').classList.toggle('btn--success')
        form.querySelector('button.btn').classList.toggle('btn--alert')
        form.action = ajaxUrl.replace(/\/[^\/]*$/, `/${newStatus}`)
    }).catch(function(error){
        console.error(error)
    })

}