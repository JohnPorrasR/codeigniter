$('.texto').on('keypress', function(e) {
    var regex = new RegExp("^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ  -_]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
        e.preventDefault();
        return false;
    }
});
$('.numero').on('keypress', function(e) {
    var regex = new RegExp("^[0-9 ]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
        e.preventDefault();
        return false;
    }
});
$('.textoNum').on('keypress', function(e) {
    var regex = new RegExp("^[a-zA-Z0-9 ]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
        e.preventDefault();
        return false;
    }
});

function validarInput(){
    var count = 0;
    var flag;
    $(".required").each(function( index ) {
        if($(this).val() == null || $(this).val() == ''){
            $(this).addClass('error');
            count = count + 1;
        }else{
            $(this).removeClass('error');
            count = count + 0;
        }
        if (count > 0) {
            flag = false;
        }else{
            flag = true;
        }
    });
    return flag;
}

$(".required").on("keypress", function(){
    if(($(this).val()).length > 0){
        $(this).removeClass('error');
    }else{
        $(this).addClass('error');
    }
});

$(".required").change(function(){
    if(($(this).val()).length > 0){
        $(this).removeClass('error');
    }else{
        $(this).addClass('error');
    }
});

function limpiar(){
    $( "input" ).each(function( index ) {
        $(this).val('');
    });
    $( "select" ).each(function( index ) {
        $(this).val('');
    });
}

function bloquearInputs(){
    $( "input" ).each(function( index ) {
        $(this).prop("disabled", true );
    });
    $( "select" ).each(function( index ) {
        $(this).prop("disabled", true );
    });
}

function dasbloquearInputs(){
    $( "input" ).each(function( index ) {
        $(this).prop("disabled", false );
    });
    $( "select" ).each(function( index ) {
        $(this).prop("disabled", false );
    });
}
/*
$('.email').keypress(function(){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    console.log(regex.test($(this).val().trim()));
    if (regex.test($(this).val().trim())) {
        $(this).removeClass('error');
    } else {
        $(this).addClass('error');
    }
});*/