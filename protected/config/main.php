<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Demo Yii1 Books Catalog',
    'charset' => 'utf-8',
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    'defaultController' => 'book',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=demo_yii1',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'emulatePrepare' => true,
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'class' => 'WebUser',
            'loginUrl' => array('site/login'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '' => 'book/index',
                'book/<id:\d+>' => 'book/view',
                'author/<id:\d+>' => 'author/view',
                'report/top-authors' => 'report/topAuthors',
                'site/<action:(login|logout)>' => 'site/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
            ),
        ),
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);
