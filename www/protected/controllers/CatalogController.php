<?php

class CatalogController extends Controller
{
    public function actionIndex()
    {
        $this->pageTitle  = 'Каталог изделий';
        $this->pageId = 'catalog';
        if(Yii::app()->request->isAjaxRequest){
            $articul = (empty($_POST['articul']))?'':$_POST['articul'];
            $name = (empty($_POST['name']))?'':$_POST['name'];
            $criteria = new CDbCriteria();
            $criteria->limit = 20;
            $criteria->addCondition('articul LIKE :articul');
            $criteria->addCondition('name LIKE :name');
            $criteria->params=array(
                ':articul'=>"%$articul%",
                ':name'=>"%$name%"
            );
            $model = Product::model()->findAll($criteria);
            if ($model == NULL)
            {
            echo <<<H
<tr>
<td colspan="15">
По данному запросу ничего не найдено.
</td>
</tr>
H;
            }
            else
            {
                foreach($model as $item)
                {
                    $price = ProductsPrices::model()->find('product_id='.$item->id);
                    if ($price == NULL)
                    {
echo <<<H
<tr>
<td>$item->articul</td>
<td>$item->name</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>
<div class="buttons">
    <a href="/catalog/page/1/$item->id"
    <button class="btn btn-mini"><span class="icon-edit"></span></button>
    </a>
    </button>
</div>
</td>
</tr>
H;
                    }
                    else
                    {
echo <<<H
<tr>
<td>$item->articul</td>
<td>$item->name</td>
<td>$price->milling</td>
<td>$price->polishing</td>
<td>$price->first_coat</td>
<td>$price->painting</td>
<td>$price->varnish</td>
<td>$price->assembling</td>
<td>$price->packing_joiner</td>
<td>$price->cant</td>
<td>$price->weldment</td>
<td>$price->metalwork</td>
<td>$price->painting_metal</td>
<td>$price->packing_metal</td>
<td>
<div class="buttons">
    <a href="/catalog/page/1/$item->id"
    <button class="btn btn-mini"><span class="icon-edit"></span></button>
    </a>
    </button>
</div>
</td>
</tr>
H;
                    }
                }
            }

            Yii::app()->end();
        }
        $criteria = new CDbCriteria();
        $count=Product::model()->count($criteria);
        $sort=new CSort('Product');
        $sort->defaultOrder='articul';
        $sort->applyOrder($criteria);
        $pages=new CPagination($count);
        // элементов на страницу
        $pages->pageSize=20;
        $pages->applyLimit($criteria);
        $products = Product::model()->findAll($criteria);
        $price = NULL;

        if (isset($_GET['id']))
        {
            $price = ProductsPrices::model()->findByAttributes(array('product_id'=>(int)$_GET['id']));
            if ($price==NULL)
            {
                $price = new ProductsPrices();
                $price->product_id = (int)$_GET['id'];

            }

        }
        $page = 1;
        if (!empty($_GET['page']))
            $page = (int) $_GET['page'];
        if(isset($_POST['ProductsPrices']))
        {

            $price->attributes=$_POST['ProductsPrices'];
            if($price->save())
            {
                $this->redirect(array('/catalog/page/'.$page));
            }
        }

        $this->render('index',array('model'=>$products,'priceModel'=>$price,'pages'=>$pages));
    }


}