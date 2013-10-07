$(document).ready(function () {
    var articul = $('input#articul');
    var name = $('input#name');
    var tBody = $('#mainBody');
    articul.keyup(function () {
        $.ajax(
            {
                type: "POST",
                url: "/catalog/index",
                data: {'articul': articul.val(),
                    'name': name.val()
                },
                beforeSend: function () {
                    tBody.empty();
                },
                success: function (response) {
                    tBody.append(response);
                },
            }
        );
    });
    name.keyup(function () {
        $.ajax(
            {
                type: "POST",
                url: "/catalog/index",
                data: {
                    'articul': articul.val(),
                    'name': name.val()
                },
                beforeSend: function () {
                    tBody.empty();
                },
                success: function (response) {
                    tBody.append(response);
                },
            }
        );
    });
});