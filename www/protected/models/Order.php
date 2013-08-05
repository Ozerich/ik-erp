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
}