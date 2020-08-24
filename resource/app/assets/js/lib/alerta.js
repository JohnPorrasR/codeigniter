function alerta(tipoMensaje, titulo, content, tiempo = 3500) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-top-center",
        "onclick": null,
        "showDuration": tiempo,
        "hideDuration": "1500",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    if (tipoMensaje === 'success') {
        toastr.success(content, titulo);
    } else if (tipoMensaje === 'info') {
        toastr.info(content, titulo);
    } else if (tipoMensaje === 'warning') {
        toastr.warning(content, titulo);
    } else if (tipoMensaje === 'error') {
        toastr.error(content, titulo);
    } else {
        toastr.success(content, titulo);
    }
}