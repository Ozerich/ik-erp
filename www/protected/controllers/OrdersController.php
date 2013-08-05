<?php

class OrdersController extends Controller
{
    public function actionGet()
    {
        $orders_all = Order::model()->findAll();

        $result = array();

        foreach ($orders_all as $_order) {
            $order = $_order->attributes;

            $products = array();

            foreach ($_order->order_products as $order_product) {
                $product = $order_product->attributes;
                $product['product'] = $order_product->product->attributes;
                $products[] = $product;
            }

            $order['products'] = $products;

            $result[] = $order;
        }

        echo json_encode($result);
        Yii::app()->end();
    }


    public function actionCreate()
    {

        $order = new Order;

        $order->date = Yii::app()->request->getPost('date');
        $order->shipping_date = Yii::app()->request->getPost('shipping_date');
        $order->worker = Yii::app()->request->getPost('worker');
        $order->division = Yii::app()->request->getPost('division');
        $order->customer = Yii::app()->request->getPost('customer');
        $order->customer_phone = Yii::app()->request->getPost('customer_phone');
        $order->comment = Yii::app()->request->getPost('comment');
        $order->need_install = Yii::app()->request->getPost('need_install');
        $order->install_address = Yii::app()->request->getPost('install_address');
        $order->install_comment = Yii::app()->request->getPost('install_comment');
        $order->install_person = Yii::app()->request->getPost('install_person');
        $order->install_phone = Yii::app()->request->getPost('install_phone');

        $order->save();

        $order_product_ids = array();
        foreach (Yii::app()->request->getPost('products', array()) as $product) {
            $product_model = Product::model()->findByPk($product['product_id']);
            if (!$product_model) {
                continue;
            }

            $order_product = new OrderProduct;
            $order_product->order_id = $order->id;
            $order_product->product_id = $product_model->id;
            $order_product->count = $product['count'];
            $order_product->comment = $product['comment'];
            $order_product->save();

            $order_product_ids[] = $order_product->id;
        }

        echo json_encode(array('order_id' => $order->id, 'order_product_ids' => $order_product_ids));
        Yii::app()->end();
    }
}
