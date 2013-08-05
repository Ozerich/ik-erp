<?php

class OrdersController extends Controller
{
    public function actionGet()
    {
        $orders_all = Order::model()->findAll();

        $result = array();

        foreach ($orders_all as $order) {
            $result[] = $order->attributes;
        }

        echo json_encode($result);
        Yii::app()->end();
    }

}

