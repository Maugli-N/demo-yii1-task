<?php

class m260226_080000_add_send_sms_log extends CDbMigration
{
    /**
     * Применяет миграцию.
     *
     * @result void - создаёт таблицу журнала отправки SMS
     */
    public function safeUp()
    {
        $tableOptions = 'ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 '
            . 'COLLATE=utf8mb4_unicode_ci';

        $this->createTable('send_sms_log', array(
            'id' => 'pk',
            'sent_at' => 'datetime NOT NULL',
            'phone' => 'varchar(32) NOT NULL',
            'message' => 'text NOT NULL',
            'status' => 'varchar(16) NOT NULL',
        ), $tableOptions);
    }

    /**
     * Откатывает миграцию.
     *
     * @result void - удаляет таблицу журнала отправки SMS
     */
    public function safeDown()
    {
        $this->dropTable('send_sms_log');
    }
}
