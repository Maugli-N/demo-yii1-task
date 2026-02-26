<?php

class TestSendSmsCommand extends CConsoleCommand
{
    /**
     * Отправляет тестовое SMS через SmsPilot.
     *
     * @param string $phone - номер телефона
     * @param string $message - текст сообщения в UTF-8
     *
     * @result int - код завершения команды
     */
    public function actionIndex($phone = null, $message = null)
    {
        if ($phone === null || $message === null) {
            $this->printUsage();
            return 1;
        }

        if (!$this->isUtf8($message)) {
            fwrite(
                STDERR,
                "Сообщение должно быть в UTF-8.\n"
            );
            return 1;
        }

        $client = new SmsPilotClient();
        $success = $client->send($phone, $message);

        if ($success) {
            echo "SMS отправлено.\n";
            return 0;
        }

        fwrite(STDERR, "Ошибка отправки SMS.\n");
        return 1;
    }

    /**
     * Проверяет строку на UTF-8.
     *
     * @param string $value - проверяемая строка
     *
     * @result bool - true, если строка в UTF-8
     */
    protected function isUtf8($value)
    {
        if (function_exists('mb_check_encoding')) {
            return mb_check_encoding($value, 'UTF-8');
        }

        return (bool)preg_match('//u', $value);
    }

    /**
     * Печатает инструкцию по использованию.
     *
     * @result void - выводит справку в STDOUT
     */
    protected function printUsage()
    {
        echo "Использование:\n";
        echo "  yiic testsendsms <phone> <message>\n";
        echo "Пример:\n";
        echo "  yiic testsendsms +79990001122 \"Тест\"\n";
    }
}
