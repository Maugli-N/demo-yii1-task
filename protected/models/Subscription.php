<?php

class Subscription extends CActiveRecord
{
    public function tableName()
    {
        return 'subscriptions';
    }

    public function rules()
    {
        return array(
            array('author_id, phone', 'required'),
            array('author_id', 'numerical', 'integerOnly' => true),
            array('phone', 'length', 'max' => 32),
            array('phone', 'match', 'pattern' => '/^[0-9\+\-\s\(\)]+$/'),
        );
    }

    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, 'Author', 'author_id'),
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
