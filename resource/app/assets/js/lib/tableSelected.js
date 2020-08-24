$(document).ready(function() {
    $('#table tbody').on('click', 'tr', function() {
        $("tr").removeClass('selected');
        $(this).addClass('selected');
    });
});