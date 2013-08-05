<?php

class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->redirect('/production');
        $this->render('index');
    }

    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if ($error['code'] == 404)
            $this->render('/system/error404', $error);
        else {
            print_r($error);
        }
    }

}