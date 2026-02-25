<?php

class SmsPilotClient
{
    const API_URL = 'https://smspilot.ru/api.php';

    public function send($phone, $message)
    {
        $apiKey = Yii::app()->params['smsPilotApiKey'];
        $sender = Yii::app()->params['smsPilotSender'];

        $payload = http_build_query(array(
            'send' => $message,
            'to' => $phone,
            'from' => $sender,
            'apikey' => $apiKey,
        ));

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => $payload,
                'timeout' => 5,
            ),
        ));

        $response = @file_get_contents(self::API_URL, false, $context);
        if ($response === false) {
            Yii::log('SmsPilot: ошибка отправки.', CLogger::LEVEL_WARNING);
            return false;
        }

        Yii::log('SmsPilot response: ' . $response, CLogger::LEVEL_INFO);
        return true;
    }
}
