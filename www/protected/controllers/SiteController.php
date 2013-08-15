<?php

class SiteController extends Controller
{
    public function actionIndex()
    {
		/*$f = fopen($_SERVER['DOCUMENT_ROOT'].'/data.csv', 'r+');
		
			while (($data = fgetcsv($f, 1000, ";")) !== FALSE) {
				if(!empty($data[0]) && !empty($data[1]) && !empty($data[2]) && !empty($data[3]) && !empty($data[4]) && !empty($data[5]) && $data[1] != 'Артикул'){
					
					$product = new Product;
					$product->articul = $data[1];
					$product->name = $data[2];
					$product->price = str_replace(array('р.',' '), array('',''), $data[4]);
					$product->unit = $data[3];
					$product->size = $data[5];
					$product->save();
				}
			}
			
		fclose($f);exit;*/
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