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

    <title><?= !empty($this->pageTitle) ? $this->pageTitle : 'Система управления предприятием'?> – «Красивый город»</title>

    <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.min.css">
    <?php
    if ($this->pageId == 'catalog')
    {
    ?>
    <link rel="stylesheet" type="text/css" href="/css/catalog-tables.css">
    <?php
    }
    ?>
    <link rel="stylesheet" type="text/css" href="/css/thirdparty/jquery-ui/jquery-ui-1.9.1.custom.min.css">

    <link rel="stylesheet/less" type="text/less" href="/css/layout.less">

    <script>var less = {env: 'development'}</script>

    <script src="/js/thirdparty/jquery-2.0.3.min.js"></script>

    <script src="/js/thirdparty/select2.js"></script>
    <script src="/js/thirdparty/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="/js/thirdparty/jquery.uniform.min.js"></script>
    <script src="/js/thirdparty/bootstrap.min.js"></script>
    <script src="/js/thirdparty/less-1.3.3.min.js"></script>
    <script src="/js/thirdparty/jquery.maskedinput.min.js"></script>
    <script src="/js/thirdparty/xeditable.min.js"></script>
    <script src="/js/thirdparty/fullcalendar.min.js"></script>

    <script src="/js/thirdparty/knockout-2.3.0.js"></script>
    <script src="/js/thirdparty/knockout-bootstrap.min.js"></script>
    <script src="/js/binding_handlers.js"></script>

    <script src="/js/init.js"></script>
    <script src="/js/datapoint.js"></script>


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

<header>
    <nav>
        <ul>
            <li><a href="/production">Производство</a>
                <ul>
                    <li><a href="/production">В работе</a></li>
                    <li><a href="/payments">Оплата труда</a></li>
                </ul>
            </li>
            <li><a href="/finance">Финансы</a></li>
            <li><a href="/provision">Снабжение</a></li>
            <li><a href="/catalog">Каталог изделий</a></li>
            <li><a href="/clients">Клиенты и сделки</a></li>
        </ul>
    </nav>
    <div class="right-block">
        <a class="logout" href="/logout"><span class="icon-off icon-white"></span> Выйти</a>
        <span class="user-name">Виталий Озерский</span>
    </div>
</header>

<div class="page-container" <?= !empty($this->pageId) ? 'id="page_'.$this->pageId.'"' : ''?>>
    <?=$content?>
</div>
</body>
</html>
