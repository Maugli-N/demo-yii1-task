<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Demo Yii1 Console',
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
            'charset' => 'utf8mb4',
            'emulatePrepare' => true,
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
);
