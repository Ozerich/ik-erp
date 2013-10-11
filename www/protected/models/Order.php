<?php

class Order extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return array();
    }

    public function relations()
    {
        return array(
            'order_products' => array(self::HAS_MANY, 'OrderProduct', 'order_id'),
            'orders_done' => array(self::HAS_MANY, 'OrdersDone', 'order_id')
        );
    }

    public function attributeLabels()
    {
        return array();
    }

    public function afterDelete()
    {
        foreach ($this->order_products as $order_product) {
            $order_product->delete();
        }
    }

    public function getPrice()
    {
        $result = 0;
        foreach ($this->order_products as $order_product) {
            $result += (int)$order_product->count * (int)$order_product->product->price;
        }
        return $result;
    }

    public function getisShipped()
    {

        $done = array();

        foreach ($this->order_products as $order_product) {
            $done[$order_product->product_id] = $order_product->count;
        }


        foreach ($this->orders_done as $order_done) {
            $done[$order_done->product_id] -= $order_done->done;
        }

        foreach ($done as $_done) {
            if ($_done > 0) {
                return false;
            }
        }

        return true;
    }
}