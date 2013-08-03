<?php

class AuthController extends Controller
{
    public $layout = 'guest';

    public function actionLogin()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $email = Yii::app()->request->getPost('email');
            $password = Yii::app()->request->getPost('password');
            $remember = Yii::app()->request->getPost('remember');

            $identity = new UserIdentity($email, $password);

            $response = array();

            if ($identity->authenticate()) {
                Yii::app()->user->login($identity, $remember == 1 ? 3600 * 24 * 7 : 0);

                $response = array(
                    'success' => 1,
                    'url' => Yii::app()->user->returnUrl
                );
            } else {
                $response = array(
                    'success' => 0,
                    'error' => 'Неверный пароль'
                );
            }

            echo json_encode($response);
            Yii::app()->end();
        }

        $this->render('login');
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/');
    }

}