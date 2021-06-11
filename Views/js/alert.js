const formAjax = document.querySelectorAll('.formAjax');

function sendFormAjax(e){
    e.preventDefault();

    let data = new FormData(this);
    let method = this.getAttribute('method');
    let action = this.getAttribute('action');
    let type = this.getAttribute('data-form');

    let headers = new Headers();

    let config = {
        method: method,
        headers: headers,
        body: data
    };

    let textAlert;

    if(type === 'save'){
        textAlert = 'Los datos quedarán guardados en el sistema';
    } else if(type === 'delete'){
        textAlert = 'Los datos serán eliminados completamente del sistema';
    } else if(type === 'update'){
        textAlert = 'Los datos serán actualizados';
    } else if(type === 'search'){
        textAlert = 'Se eliminarán los términos de búsqueda';
    } else if(type === 'loans'){
        textAlert = 'Remover los datos seleccionados para préstamos o reservaciones';
    } else{
        textAlert = 'Quieres realizar la operación solicitada';
    }

    Swal.fire({
        title: '¿Estas seguro?',
        text: textAlert,
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if(result.value){
            fetch(action, config)
            .then(res => {
                return res.ok ? res.json() : Promise.reject(res);
            })
            .then(res => {
                return alertAjax(res);
            })
            .catch(error => {
                console.log('El error es: ', error);
            })
        }
    });
}

formAjax.forEach(form => {
    form.addEventListener('submit', sendFormAjax);
})

function alertAjax(alert){
    if(alert.Alert === 'simple'){
        Swal.fire({
            title: alert.Title,
            text: alert.Text,
            type: alert.Type,
            confirmButtonText: 'Aceptar'
        })
    } else if (alert.Alert === 'reload') {
        Swal.fire({
            title: alert.Title,
            text: alert.Text,
            type: alert.Type,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.value) {
                location.reload();
            }
        })
    } else if (alert.Alert === 'clean'){
        Swal.fire({
            title: alert.Title,
            text: alert.Text,
            type: alert.Type,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.value) {
                document.querySelector('.formAjax').reset();
            }
        })
    } else if(alert.Alert === 'redirect'){
        windows.location.href = alerta.URL;
    }
}