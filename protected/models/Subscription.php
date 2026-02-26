<?php

class Subscription extends CActiveRecord
{
    /**
     * Возвращает имя таблицы модели.
     *
     * @result string - имя таблицы
     */
    public function tableName()
    {
        return 'subscriptions';
    }

    /**
     * Возвращает правила валидации модели.
     *
     * @result array - правила валидации
     */
    public function rules()
    {
        return array(
            array('author_id, phone', 'required'),
            array('author_id', 'numerical', 'integerOnly' => true),
            array('phone', 'length', 'max' => 32),
            array(
                'phone',
                'match',
                'pattern' => '/^[0-9\\+\\-\\s\\(\\)]+$/',
            ),
        );
    }

    /**
     * Возвращает связи модели.
     *
     * @result array - описание связей
     */
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, 'Author', 'author_id'),
        );
    }

    /**
     * Действия перед сохранением модели.
     *
     * @result bool - разрешение на сохранение
     */
    public function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
        }

        return true;
    }

    /**
     * Возвращает статическую модель.
     *
     * @param string $className - имя класса
     *
     * @result Subscription - модель ActiveRecord
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
