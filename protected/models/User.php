<?php

class User extends CActiveRecord
{
    public $password;

    public function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return array(
            array('username, role', 'required'),
            array('username', 'length', 'max' => 64),
            array('role', 'in', 'range' => array('user')),
            array('password', 'required', 'on' => 'insert'),
            array('password', 'length', 'min' => 6, 'max' => 255),
        );
    }

    public function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }

        if (!empty($this->password)) {
            $this->password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        }

        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
        }

        return true;
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password_hash);
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
