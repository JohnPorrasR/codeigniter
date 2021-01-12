$(document).ready(function() {
    $('#tabla1 tbody').on('click', 'tr', function() {
        $("tr").removeClass('selected');
        $(this).addClass('selected');
    });
});

$(document).ready(function() {
    $('#tabla2 tbody').on('click', 'tr', function() {
        $("tr").removeClass('selected');
        $(this).addClass('selected');
    });
});

$(document).ready(function() {
    $('#tabla3 tbody').on('click', 'tr', function() {
        $("tr").removeClass('selected');
        $(this).addClass('selected');
    });
});