<?php

class User extends CActiveRecord
{
    public $password;

    /**
     * Возвращает имя таблицы модели.
     *
     * @result string - имя таблицы
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * Возвращает правила валидации модели.
     *
     * @result array - правила валидации
     */
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

        if (!empty($this->password)) {
            $this->password_hash = password_hash(
                $this->password,
                PASSWORD_BCRYPT
            );
        }

        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
        }

        return true;
    }

    /**
     * Проверяет пароль пользователя.
     *
     * @param string $password - пароль для проверки
     *
     * @result bool - результат проверки
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password_hash);
    }

    /**
     * Возвращает статическую модель.
     *
     * @param string $className - имя класса
     *
     * @result User - модель ActiveRecord
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
