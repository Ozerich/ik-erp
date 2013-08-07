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


    public function actionSubmit()
    {
        $id = Yii::app()->request->getPost('id');

        if ($id) {
            $order = Order::model()->findByPk($id);
        } else {
            $order = new Order;
        }

        if (!$order) {
            throw new CHttpException(404);
        }

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

            $order_product = $product['id'] ? OrderProduct::model()->findByPk($product['id']) : new OrderProduct;
            $order_product->order_id = $order->id;
            $order_product->product_id = $product_model->id;
            $order_product->count = $product['count'];
            $order_product->comment = $product['comment'];
            $order_product->save();

            $order_product_ids[] = $order_product->id;
        }

        foreach ($order->order_products as $order_product) {
            if (!in_array($order_product->id, $order_product_ids)) {
                $order_product->delete();
            }
        }

        echo json_encode(array('order_id' => $order->id, 'order_product_ids' => $order_product_ids));
        Yii::app()->end();
    }


    public function actionChangeState()
    {
        $order_product_id = Yii::app()->request->getPost('order_product_id');
        $state = Yii::app()->request->getPost('state');
        $value = Yii::app()->request->getPost('value');

        $order_product = OrderProduct::model()->findByPk($order_product_id);
        if (!$order_product) {
            throw new CHttpException(404);
        }

        if ($state == 1) {
            $order_product->state_1 = $value ? 1 : 0;
        }
        if ($state == 2) {
            $order_product->state_2 = $value ? 1 : 0;
        }
        if ($state == 3) {
            $order_product->state_3 = $value ? 1 : 0;
        }

        $order_product->save();
        Yii::app()->end();
    }


    public function actionSaveComment()
    {
        $order_product_id = Yii::app()->request->getPost('pk');
        $value = Yii::app()->request->getPost('value');

        $order_product = OrderProduct::model()->findByPk($order_product_id);
        if (!$order_product) {
            throw new CHttpException(404);
        }

        $order_product->comment = $value;
        $order_product->save();

        Yii::app()->end();
    }

    public function actionChangeStatus()
    {
        $order_id = Yii::app()->request->getPost('order_id');
        $status = Yii::app()->request->getPost('status');

        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            throw new CHttpException(404);
        }

        $order->status = $status;
        $order->save();

        Yii::app()->end();
    }
}

