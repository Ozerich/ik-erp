<?php

class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->redirect('/production');
        $this->render('index');
    }


}