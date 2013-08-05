<?php

class ProductsController extends Controller
{

    public function actionGet()
    {
        $products_all = Product::model()->findAll();

        $result = array();

        foreach ($products_all as $product) {
            $result[] = $product->attributes;
        }

        echo json_encode($result);
        Yii::app()->end();
    }


}

