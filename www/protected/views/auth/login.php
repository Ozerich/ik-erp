<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <meta name="author" content="Vital Ozierski, ozicoder@gmail.com">

    <!--[if gt IE 8]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <![endif]-->

    <link rel="icon" type="image/png" href="/img/favicon.png"/>

    <title>Система управления предприятием – «Красивый город»</title>


    <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">


    <link rel="stylesheet/less" type="text/less" href="/css/layout.less">
    <link rel="stylesheet/less" type="text/less" href="/css/login/login.less">

    <script>var less = {env: 'development'}</script>

    <script src="/js/thirdparty/jquery-2.0.3.min.js"></script>
    <script src="/js/thirdparty/less-1.3.3.min.js"></script>

    <script src="/js/thirdparty/jquery.uniform.min.js"></script>

    <script>
        $(function () {
            $('input:checkbox').uniform();

            $('form').on('submit', function () {

                $('.error-block').hide();
                $('.submit-block').hide();
                $('.loader').show();

                $.ajax({
                    url: '/login',
                    method: 'post',
                    data: {
                        email: $('input[name=email]').val(),
                        password: $('input[name=password]').val(),
                        remember: $('input[type=checkbox]').is(':checked') ? 1 : 0
                    },
                    success: function (data) {
                        data = jQuery.parseJSON(data);
                        if (data.success) {
                            document.location.href = data.url;
                        }
                        else {
                            $('.error-block').show().find('span').text(data.error);
                            $('.submit-block').show();
                            $('.loader').hide();
                        }
                    },
                    error: function(){
                        $('.submit-block').show();
                        $('.loader').hide();
                    }
                });

                return false;
            });
        });
    </script>

</head>
<!--[if lt IE 7 ]>
<body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>
<body class="ie ie7"> <![endif]-->
<!--[if IE 8 ]>
<body class="ie ie8"> <![endif]-->
<!--[if IE 9 ]>
<body class="ie ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body>
<!--<![endif]-->

<div class="header">
</div>

<div class="login" id="login">
    <div class="wrap">
        <h1>Вход в панель управления</h1>

        <form action="index.html" method="post" id="validate">
            <div class="row-fluid">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" name="email" value="" placeholder="E-mail" style="width: 254px;"
                           class="validate[required]"/>
                </div>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-exclamation-sign"></i></span>
                    <input type="password" name="password" value="" placeholder="Пароль" style="width: 254px;"
                           class="validate[required]"/>
                </div>
                <div class="error-block" style="display: none">
                    <span class="error" style="color: red;">Неверный пароль</span>
                </div>
                <div class="dr"><span></span></div>
            </div>
            <div class="row-fluid">
                <div class="span6 remember">
                    <input type="checkbox" name="rem"/> Запомнить
                </div>
                <div class="span6 TAR">
                    <img style="display: none;margin-top: 8px" class="loader" src="/img/loaders/1d_2.gif">

                    <div class="span6 submit-block" style="float: right">
                        <input type="submit" class="btn btn-block btn-primary" value="Войти"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


</body>
</html>
