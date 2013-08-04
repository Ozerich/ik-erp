$(function () {
    $('#calendar').Calendar();

    $('input:checkbox').uniform();

    $('select').each(function(){
        $(this).select2({
            minimumResultsForSearch: 99
        });
    });

    $( ".spinner" ).spinner();

    $(".datepicker").datepicker({dateFormat: 'dd.mm.yy'});

    $('#order_form .nav-tabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('#btn_new_order').on('click', function () {
        $('#order_form').modal();
        return false;
    });
});
