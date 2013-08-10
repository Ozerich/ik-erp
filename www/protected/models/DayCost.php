<?php

class DayCost extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'day_costs';
    }

    public static function All()
    {
        $result = array();
        foreach(self::model()->findAll() as $item){
            $result[$item->date] = (int)$item->cost;
        }
        return $result;
    }
}