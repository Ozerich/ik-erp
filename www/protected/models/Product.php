<?php

class Product extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'products';
    }

    public function rules()
    {
        return array(
            array('name, articul, price', 'required'),
        );
    }

    public function relations()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название продукта',
            'articul' => 'Артикул',
            'price' => 'Цена',
        );
    }
}