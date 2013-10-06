<?php

class OrderProduct extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'order_products';
    }

    public function rules()
    {
        return array(
            array('order_id, product_id, count, pos', 'required'),
            array('comment, state_1, state_2, state_3', 'safe')
        );
    }

    public function relations()
    {
        return array(
            'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'done' => array(self::HAS_MANY, 'OrdersDone', array('order_id'=>'order_id','product_id'=>'product_id')),
        );
    }

    public function defaultScope()
    {
        return array(
            'order' => 'pos ASC'
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $model = new self;

            $criteria = new CDbCriteria;
            $criteria->select = 'max(pos) AS pos';
            $criteria->compare('order_id', $this->order_id);
            $row = $model->model()->find($criteria);

            $this->pos = $row['pos'] + 1;
        }

        return true;
    }

}