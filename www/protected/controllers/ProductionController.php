<?php

class ProductionController extends Controller
{
    public function actionIndex()
    {
        $this->pageTitle = 'Производство';
        $this->pageId = 'production';

        $this->render('index');
    }


}