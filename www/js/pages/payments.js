$(function () {

    var openBtn = $('.icon-plus-sign').parent();
    var closeBtn = $('.icon-minus-sign').parent();
    var showHideBtn = $('.showHide');

    openBtn.click(function () {
        var x = $(this).parent().parent().parent().parent().parent().parent();
        x.find('table.prices').fadeIn();
        $(this).hide();
        $(this).parent().find('.btn-hide').show();
    });

    closeBtn.click(function () {
        var x = $(this).parent().parent().parent().parent().parent().parent();
        x.find('table.prices').fadeOut();
        $(this).hide();
        $(this).parent().find('.btn-open').show();
    });

    showHideBtn.click(function (e) {
        if (openBtn.css('display') == 'block')
            openBtn.click();
        else
            closeBtn.click();
        return false;
    });

    $('.printChecked').on('click', function () {
        $(this).hide();
        $('.printCancel').show();
        $('td.print-buttons').show();
        $(this).parents('.btn-group').removeClass('open');
        return false;
    });

    $('.printCancel').on('click', function () {
        $(this).hide();
        $('.printChecked').show();
        $('td.print-buttons').hide();
        $(this).parents('.btn-group').removeClass('open');
        return false;
    });

    $('.doPrint').on('click', function () {

        if ($('td.print-buttons').is(':visible')) {

            var exceptions = [];
            $('article').each(function () {
                if ($(this).find('.print-buttons input').is(':checked') == false) {
                    exceptions.push($(this).data('id'));
                    $(this).hide();
                }
            });

            window.print();

            for (var i = 0; i < exceptions.length; i++) {
                $('article[data-id=' + exceptions[i] + ']').show();
            }

        }
        else {
            window.print();
        }

        $(this).parents('.btn-group').removeClass('open');

        return false;
    });

    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            if ($('td.print-buttons').is(':visible')) {
                $('.printCancel').trigger('click');
            }
        }
    });
});