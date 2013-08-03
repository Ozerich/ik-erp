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
        if($error=Yii::app()->errorHandler->error)
            $this->render('/system/error404', $error);
    }

}