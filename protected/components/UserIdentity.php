<?php

class UserIdentity extends CUserIdentity
{
    private $_id;

    /**
     * Аутентифицирует пользователя по логину и паролю.
     *
     * @result bool - результат аутентификации
     */
    public function authenticate()
    {
        $user = User::model()->findByAttributes(array(
            'username' => $this->username,
        ));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }

        if (!$user->verifyPassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        }

        $this->_id = $user->id;
        $this->setState('role', $user->role);
        $this->errorCode = self::ERROR_NONE;
        return true;
    }

    /**
     * Возвращает идентификатор пользователя.
     *
     * @result int|null - идентификатор пользователя
     */
    public function getId()
    {
        return $this->_id;
    }
}
