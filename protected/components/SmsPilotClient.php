<?php

class SmsPilotClient
{
    const API_URL = 'https://smspilot.ru/api.php';

    /**
     * Отправляет SMS через SmsPilot.
     *
     * @param string $phone - телефон получателя
     * @param string $message - текст сообщения
     *
     * @result bool - успех отправки
     */
    public function send($phone, $message)
    {
        $apiKey = Yii::app()->params['smsPilotApiKey'];
        $sender = Yii::app()->params['smsPilotSender'];
        $status = 'error';
        $details = null;

        $payload = http_build_query(array(
            'send' => $message,
            'to' => $phone,
            'from' => $sender,
            'apikey' => $apiKey,
        ));

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                    "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => $payload,
                'timeout' => 5,
            ),
        ));

        $response = @file_get_contents(self::API_URL, false, $context);
        if ($response === false) {
            $lastError = error_get_last();
            if (is_array($lastError) && isset($lastError['message'])) {
                $details = $lastError['message'];
            } else {
                $details = 'Не удалось получить ответ от SmsPilot.';
            }
            Yii::log(
                'SmsPilot: ошибка отправки.',
                CLogger::LEVEL_WARNING
            );
            $this->logSms($phone, $message, $status, $details);
            return false;
        }

        Yii::log(
            'SmsPilot response: ' . $response,
            CLogger::LEVEL_INFO
        );
        $status = 'success';
        $details = $response;
        $this->logSms($phone, $message, $status, $details);
        return true;
    }

    /**
     * Журналирует отправку SMS.
     *
     * @param string $phone - номер телефона
     * @param string $message - текст сообщения
     * @param string $status - статус отправки
     *
     * @result void - сохраняет запись в журнал
     */
    protected function logSms($phone, $message, $status, $details)
    {
        try {
            Yii::app()->db->createCommand()->insert('send_sms_log', array(
                'sent_at' => new CDbExpression('NOW()'),
                'phone' => $phone,
                'message' => $message,
                'status' => $status,
                'details' => $details,
            ));
        } catch (Exception $exception) {
            Yii::log(
                'SmsPilot: ошибка записи в журнал.',
                CLogger::LEVEL_WARNING
            );
        }
    }
}
