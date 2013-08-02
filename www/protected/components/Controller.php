<?php

class Controller extends CController
{
    public $layout = '//layouts/main';

    public $menu = array();

    public $breadcrumbs = array();

    public $active_page = '';

    public function beforeAction($action)
    {
        if (Yii::app()->user->isGuest && $action->id != 'login') {
            $this->redirect('/auth/login');
        }

        return parent::beforeAction($action);
    }

}