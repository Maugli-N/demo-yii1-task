<?php

class Author extends CActiveRecord
{
    public function tableName()
    {
        return 'authors';
    }

    public function rules()
    {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 255),
        );
    }

    public function relations()
    {
        return array(
            'books' => array(self::MANY_MANY, 'Book', 'book_author(author_id, book_id)'),
            'subscriptions' => array(self::HAS_MANY, 'Subscription', 'author_id'),
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
