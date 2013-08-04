$(function () {
    $('#calendar').Calendar();

    $('#btn_new_order').on('click', function(){
        $('#fModal').modal();
        return false;
    });
});