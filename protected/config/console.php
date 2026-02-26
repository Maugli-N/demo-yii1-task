<?php

$basePath = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
if ($basePath === false) {
    $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..';
}

$params = require(dirname(__FILE__) . '/params.php');

return array(
    'basePath' => $basePath,
    'name' => 'Demo Yii1 Console',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'commandMap' => array(
        'migrate' => array(
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'application.migrations',
        ),
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=' . $params['dbHost']
                . ';dbname=' . $params['dbName'],
            'username' => $params['dbUser'],
            'password' => $params['dbPassword'],
            'charset' => $params['dbCharset'],
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
    'params' => $params,
);
