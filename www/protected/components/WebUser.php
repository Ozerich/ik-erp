<?php

class WebUser extends CWebUser {

    private $_model = null;

    public function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
    }

    protected function beforeLogin(){
        $this->returnUrl=array('/');
        return true;
    }
}