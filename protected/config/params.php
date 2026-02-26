<?php

/**
 * Загружает переменные окружения из файла.
 *
 * @param string $envFile - путь к файлу .env
 *
 * @result array - массив переменных окружения
 */
function loadEnv($envFile)
{
    $env = array();
    if (!is_file($envFile)) {
        return $env;
    }

    $lines = file(
        $envFile,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );
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

    return $env;
}

$envFile = dirname(__FILE__) . '/../../.env';
$env = loadEnv($envFile);

$dbHost = isset($env['DB_HOST']) ? $env['DB_HOST'] : 'localhost';
$dbName = isset($env['DB_NAME']) ? $env['DB_NAME'] : 'demo_yii1_db';
$dbUser = isset($env['DB_USER']) ? $env['DB_USER'] : 'demo_yii1_user';
$dbPassword = isset($env['DB_PASSWORD'])
    ? $env['DB_PASSWORD']
    : 'demo_yii1_pass';
$dbCharset = isset($env['DB_CHARSET'])
    ? $env['DB_CHARSET']
    : 'utf8mb4';
$smsPilotApiKey = isset($env['SMS_PILOT_API_KEY'])
    ? $env['SMS_PILOT_API_KEY']
    : 'EMULATOR_KEY';
$smsPilotSender = isset($env['SMS_PILOT_SENDER'])
    ? $env['SMS_PILOT_SENDER']
    : 'INFO';

return array(
    'dbHost' => $dbHost,
    'dbName' => $dbName,
    'dbUser' => $dbUser,
    'dbPassword' => $dbPassword,
    'dbCharset' => $dbCharset,
    'smsPilotApiKey' => $smsPilotApiKey,
    'smsPilotSender' => $smsPilotSender,
    'uploadDir' => dirname(__FILE__) . '/../../web/uploads',
);
