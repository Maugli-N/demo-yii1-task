<?php

$envFile = dirname(__FILE__) . '/../../.env';
$env = array();
if (is_file($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        if (strpos($line, '=') === false) {
            continue;
        }
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if ($value !== '' && ($value[0] === '"' || $value[0] === "'")) {
            $value = trim($value, "\"'");
        }
        $env[$key] = $value;
    }
}

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
            'connectionString' => 'mysql:host=' . (isset($env['DB_HOST']) ? $env['DB_HOST'] : 'localhost')
                . ';dbname=' . (isset($env['DB_NAME']) ? $env['DB_NAME'] : 'demo_yii1'),
            'username' => isset($env['DB_USER']) ? $env['DB_USER'] : 'root',
            'password' => isset($env['DB_PASSWORD']) ? $env['DB_PASSWORD'] : '',
            'charset' => isset($env['DB_CHARSET']) ? $env['DB_CHARSET'] : 'utf8mb4',
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
