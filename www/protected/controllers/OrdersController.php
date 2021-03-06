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

                $product['done'] = 0;
                foreach ($order_product->done as $done) {
                    $product['done'] += $done->done;
                }

                $products[] = $product;
            }

            $order['products'] = $products;
            $order['is_shipped'] = $_order->isShipped;

            $result[] = $order;
        }

        $day_costs = array();
        foreach (DayCost::model()->findAll() as $day_cost) {
            $day_costs[$day_cost->date] = $day_cost->cost;
        }

        $result = array(
            'orders' => $result,
            'day_costs' => $day_costs
        );

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

        if ($order->isNewRecord) {
            $order->date_start = $order->fact_shipping_date = $order->shipping_date;
            $order->date_status = date('Y-m-d h:i:s');
        }

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

        echo json_encode(array('order_id' => $order->id, 'order_order' => $order->order, 'order_product_ids' => $order_product_ids));
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

        if ($status == 0) {
            $order->order = 0;
        } else if ($order->status == 0) {
            $order->order = $order->getNextOrder();
        }

        $order->date_status = date('Y-m-d h:i:s');
        $order->status = $status;
        $order->save();

        echo json_encode(array(
            'order_order' => $order->order
        ));

        Yii::app()->end();
    }

    public function actionUpdateDateCost()
    {
        $date = Yii::app()->request->getPost('date');
        $cost = Yii::app()->request->getPost('cost');

        $model = DayCost::model()->findByAttributes(array(
            'date' => $date
        ));
        if (!$model) {
            $model = new DayCost;
            $model->date = $date;
        }

        $model->cost = $cost;
        $model->save();

        Yii::app()->end();
    }


    public function actionCalculateDates()
    {
        $month = Yii::app()->request->getPost('month');
        $year = Yii::app()->request->getPost('year');

        $start_date = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $end_date = date('Y-m-d', mktime(0, 0, 0, $month + 1, 0, $year));

        $criteria = new CDbCriteria();
        $criteria->order = 'status DESC, "order" ASC';

        $orders = array();
        foreach (Order::model()->findAll($criteria) as $_order) {
            if (strtotime($_order->date) >= strtotime($start_date) && strtotime($_order->date) <= strtotime($end_date)) {
                $orders[] = $_order;
            }
        }

        $weights = DayCost::All();

        if (count($orders) > 0) {
            $current_date = strtotime($orders[0]->date_start);
            $order_ind = 0;
            $weight_last = 0;

            while ($order_ind < count($orders)) {
                $current_order = $orders[$order_ind];

                $current_order->date_start = date('Y-m-d', $current_date);
                $current_order->save();

                $order_weight = 0;
                while (true) {
                    $day_cost = isset($weights[date('Y-m-d', $current_date)]) ? $weights[date('Y-m-d', $current_date)] : 0;

                    if ($weight_last) {
                        $day_cost = $weight_last;
                        $weight_last = 0;
                    }

                    if ($day_cost == 0) {
                        $current_order->fact_shipping_date = date('Y-m-d', $current_date);
                        $current_order->save();
                        $weight_last = 0;
                        break;
                    } else {
                        $order_weight += $day_cost;
                        if ($order_weight >= $current_order->getPrice()) {
                            $weight_last = $order_weight - $current_order->price;
                            $current_order->fact_shipping_date = date('Y-m-d', $current_date);
                            $current_order->save();
                            break;
                        } else {
                            $current_date += 86400;
                        }
                    }
                }

                $order_ind++;
            }
        }

        echo json_encode(array());

        Yii::app()->end();
    }


    public function actionSaveOrderComment()
    {
        $comment = Yii::app()->request->getPost('value');
        $pk = Yii::app()->request->getPost('pk');

        $order = Order::model()->findByPk($pk);
        if (!$order) {
            throw new CHttpException(404);
        }

        $order->comment = $comment;
        $order->save();

        Yii::app()->end();
    }


    public function actionUpdateShippingDate()
    {
        $order_id = Yii::app()->request->getPost('order_id');
        $date = Yii::app()->request->getPost('date');

        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            throw new CHttpException(404);
        }

        $order->shipping_date = $date;
        $order->save();

        Yii::app()->end();

    }

    public function actionDelete()
    {
        $order_id = Yii::app()->request->getPost('order_id');

        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            throw new CHttpException(404);
        }

        if ($order->status != 0) {
            throw new CException("Ошибка доступа");
        }

        $order->delete();

        Yii::app()->end();
    }


    public function actionToggleOrder()
    {
        $order_id = Yii::app()->request->getPost('order_id');

        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            throw new CHttpException(404);
        }

        $mode = Yii::app()->request->getPost('mode');

        if ($mode != '1' && $mode != '-1') {
            throw new CHttpException(404);
        }

        $other = null;

        $other_all = $order->findOtherInCurrentMonth();
        foreach ($other_all as $item) {

            if ($mode == '1' && $item->order > $order->order && ($other == null || $item->order < $other->order)) {
                $other = $item;
            }

            if ($mode == '-1' && $item->order < $order->order && ($other == null || $item->order > $other->order)) {
                $other = $item;
            }

        }

        if ($other) {

            $t = $other->order;
            $other->order = $order->order;
            $order->order = $t;

            $other->save();
            $order->save();
        }

        $response = array(
            'new_order' => $order->order,
            'other_order_id' => $other ? $other->id : 0
        );

        echo json_encode($response);
        Yii::app()->end();
    }

    public function actionChangeOrder()
    {
        $order_id = Yii::app()->request->getPost('order_id');

        $model = Order::model()->findByPk($order_id);
        if (!$model) {
            throw new CHttpException(404);
        }

        $model->order = Yii::app()->request->getPost('order');
        $model->date = Yii::app()->request->getPost('date');
        $model->save();

        Yii::app()->end();
    }


    public function actionProducts($id = 0){

        $model = Order::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404);
        }

        $this->renderPartial('//production/_order_products_modal_list', array('products' => $model->order_products));
    }
}

