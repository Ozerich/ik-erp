<?php

class Controller extends CController
{
    public $layout = '//layouts/main';

    public $breadcrumbs = array();

    public $pageId = '';
    public $pageTitle = '';

    public function beforeAction($action)
    {
        if (Yii::app()->user->isGuest && $action->id != 'login') {
            $this->redirect('/login');
        } else if (Yii::app()->user->isGuest == false && $action->id == 'login') {
            $this->redirect('/');
        }

        return parent::beforeAction($action);
    }

}