<?php

$envFile = dirname(__FILE__) . '/../../.env';
$env = array();
if (is_file($envFile)) {
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
}

$smsPilotApiKey = isset($env['SMS_PILOT_API_KEY'])
    ? $env['SMS_PILOT_API_KEY']
    : 'EMULATOR_KEY';
$smsPilotSender = isset($env['SMS_PILOT_SENDER'])
    ? $env['SMS_PILOT_SENDER']
    : 'INFO';

return array(
    'smsPilotApiKey' => $smsPilotApiKey,
    'smsPilotSender' => $smsPilotSender,
    'uploadDir' => dirname(__FILE__) . '/../../web/uploads',
);
