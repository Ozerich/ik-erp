<?php

/**
 * This is the model class for table "products_prices".
 *
 * The followings are the available columns in table 'products_prices':
 * @property integer $id
 * @property integer $product_id
 * @property double $milling
 * @property double $polishing
 * @property double $first_coat
 * @property double $painting
 * @property double $varnish
 * @property double $assembling
 * @property double $packing_joiner
 * @property double $cant
 * @property double $weldment
 * @property double $metalwork
 * @property double $painting_metal
 * @property double $packing_metal
 */
class ProductsPrices extends CActiveRecord
{
    public $sum1, $sum2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProductsPrices the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'products_prices';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id', 'required'),
            array('product_id', 'numerical', 'integerOnly' => true),
            array('milling, polishing, first_coat, painting, varnish, assembling, packing_joiner, cant, weldment, metalwork, painting_metal, packing_metal', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, product_id, milling, polishing, first_coat, painting, varnish, assembling, packing_joiner, cant, weldment, metalwork, painting_metal, packing_metal', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'product_id' => 'Продукт',
            'milling' => 'Фрезеровка',
            'polishing' => 'Шлифовка',
            'first_coat' => 'Грунтовка',
            'painting' => 'Покраска',
            'varnish' => 'Лак',
            'assembling' => 'Сборка',
            'packing_joiner' => 'Упаковка и маркировка',
            'cant' => 'ФОТ Брус',
            'weldment' => 'Сварка',
            'metalwork' => 'Слесарка',
            'painting_metal' => 'Малярные работы',
            'packing_metal' => 'Упаковка и маркировка',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('milling', $this->milling);
        $criteria->compare('polishing', $this->polishing);
        $criteria->compare('first_coat', $this->first_coat);
        $criteria->compare('painting', $this->painting);
        $criteria->compare('varnish', $this->varnish);
        $criteria->compare('assembling', $this->assembling);
        $criteria->compare('packing_joiner', $this->packing_joiner);
        $criteria->compare('cant', $this->cant);
        $criteria->compare('weldment', $this->weldment);
        $criteria->compare('metalwork', $this->metalwork);
        $criteria->compare('painting_metal', $this->painting_metal);
        $criteria->compare('packing_metal', $this->packing_metal);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function formatData()
    {
        foreach ($this as $key => $value) {
            $this->$key = round($value, 2);
            if ($this->$key == 0)
                $this->$key = NULL;

        }
    }


    public function getSums()
    {
        $this->sum1 = $this->sum2 = 0;
        $this->sum1 += $this->milling + $this->polishing + $this->first_coat + $this->painting + $this->varnish + $this->assembling;
        $this->sum2 += $this->weldment + $this->metalwork + $this->painting_metal + $this->packing_metal;
    }
}