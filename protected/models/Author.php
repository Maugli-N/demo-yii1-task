<?php

class Author extends CActiveRecord
{
    /**
     * Возвращает имя таблицы модели.
     *
     * @result string - имя таблицы
     */
    public function tableName()
    {
        return 'authors';
    }

    /**
     * Возвращает правила валидации модели.
     *
     * @result array - правила валидации
     */
    public function rules()
    {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 255),
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
            'books' => array(
                self::MANY_MANY,
                'Book',
                'book_author(author_id, book_id)',
            ),
            'subscriptions' => array(
                self::HAS_MANY,
                'Subscription',
                'author_id',
            ),
        );
    }

    /**
     * Возвращает статическую модель.
     *
     * @param string $className - имя класса
     *
     * @result Author - модель ActiveRecord
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
