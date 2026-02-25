<?php

class LoginForm extends CFormModel
{
    public $username;
    public $password;
    private $_identity;

    public function rules()
    {
        return array(
            array('username, password', 'required'),
        );
    }

    public function authenticate()
    {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }

        return $this->_identity;
    }

    public function login()
    {
        $identity = $this->authenticate();
        if ($identity->errorCode === UserIdentity::ERROR_NONE) {
            Yii::app()->user->login($identity, 3600 * 24 * 7);
            return true;
        }

        $this->addError('password', 'Неверный логин или пароль.');
        return false;
    }
}
