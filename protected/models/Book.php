<?php

class Book extends CActiveRecord
{
    public $author_ids = array();
    public $coverFile;

    public function tableName()
    {
        return 'books';
    }

    public function rules()
    {
        return array(
            array('title, year, isbn', 'required'),
            array('title', 'length', 'max' => 255),
            array('isbn', 'length', 'max' => 32),
            array('year', 'numerical', 'integerOnly' => true, 'min' => 1500, 'max' => 2100),
            array('description', 'safe'),
            array('coverFile', 'file', 'types' => 'jpg,jpeg,png,gif', 'allowEmpty' => true),
            array('author_ids', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'authors' => array(self::MANY_MANY, 'Author', 'book_author(book_id, author_id)'),
        );
    }

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

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
