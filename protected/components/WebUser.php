<?php

class WebUser extends CWebUser
{
    /**
     * Возвращает роль текущего пользователя.
     *
     * @result string - роль пользователя
     */
    public function getRole()
    {
        return $this->getState('role', 'guest');
    }

    /**
     * Проверяет, является ли пользователь авторизованным.
     *
     * @result bool - признак авторизации
     */
    public function isUser()
    {
        return !$this->isGuest;
    }
}
