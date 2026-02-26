<?php

class m260226_081000_add_send_sms_log_details extends CDbMigration
{
    /**
     * Применяет миграцию.
     *
     * @result void - добавляет поле для деталей отправки
     */
    public function safeUp()
    {
        $this->addColumn('send_sms_log', 'details', 'text');
    }

    /**
     * Откатывает миграцию.
     *
     * @result void - удаляет поле деталей отправки
     */
    public function safeDown()
    {
        $this->dropColumn('send_sms_log', 'details');
    }
}
