<?php
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Панель управления "Красивый город"',

    'language' => 'ru',

    'import' => array(
        'application.models.*',
        'application.components.*',
    ),

    'components' => array(

        'user' => array(
            'class' => 'WebUser',
            'loginUrl' => array('/login'),
            'allowAutoLogin' => true,
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'login' => 'auth/login',
                'logout' => 'auth/logout',

                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>/id/<id>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),

        'db' => require(dirname(__FILE__) . '/db.php'),

        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),

    ),

    'params' => array(
    )
);