<?php

class UserIdentity extends CUserIdentity
{
    private $_id;
    public $role;

    public function authenticate()
    {
        $user = User::model()->findByAttributes(array('email' => $this->username));

        if ($user === null || !$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->id;
            $this->username = $user->email;
            $this->errorCode = self::ERROR_NONE;

            $user->last_login = date('Y-m-d H:i:s');
            $user->save();
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}