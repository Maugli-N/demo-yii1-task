<?php

class WebUser extends CWebUser
{
    public function getRole()
    {
        return $this->getState('role', 'guest');
    }

    public function isUser()
    {
        return !$this->isGuest;
    }
}
