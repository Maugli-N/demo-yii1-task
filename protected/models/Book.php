<?php

class Book extends CActiveRecord
{
    public $author_ids = array();
    public $coverFile;

    /**
     * Возвращает имя таблицы модели.
     *
     * @result string - имя таблицы
     */
    public function tableName()
    {
        return 'books';
    }

    /**
     * Возвращает правила валидации модели.
     *
     * @result array - правила валидации
     */
    public function rules()
    {
        return array(
            array('title, year, isbn', 'required'),
            array('title', 'length', 'max' => 255),
            array('isbn', 'length', 'max' => 32),
            array(
                'year',
                'numerical',
                'integerOnly' => true,
                'min' => 1500,
                'max' => 2100,
            ),
            array('description', 'safe'),
            array(
                'coverFile',
                'file',
                'types' => 'jpg,jpeg,png,gif',
                'allowEmpty' => true,
            ),
            array('author_ids', 'safe'),
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
            'authors' => array(
                self::MANY_MANY,
                'Author',
                'book_author(book_id, author_id)',
            ),
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
     * @result Book - модель ActiveRecord
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
