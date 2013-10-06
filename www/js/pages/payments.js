$(document).ready(function(){
    var openBtn = $('.icon-plus-sign').parent();
    var closeBtn = $('.icon-minus-sign').parent();
    var showHideBtn = $('.showHide');
    openBtn.click(function(){
        var x = $(this).parent().parent().parent().parent().parent().parent();
        x.find('table.prices').fadeIn();
        $(this).hide();
        $(this).parent().find('.btn-hide').show();
    });
    closeBtn.click(function(){
        var x = $(this).parent().parent().parent().parent().parent().parent();
        x.find('table.prices').fadeOut();
        $(this).hide();
        $(this).parent().find('.btn-open').show();
    });
    showHideBtn.click(function(e){
        if (openBtn.css('display') == 'block')
            openBtn.click();
        else
            closeBtn.click();
        return false;
    });


});