<?php

class AuthController extends Controller
{
    public $layout = 'guest';

    public function actionLogin()
    {
        $this->render('login');
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/');
    }

}