<?php
if (empty($_GET['page']))
    $_GET['page'] = 1;
?>
<div class="content">

<div class="row-fluid">

<div class="widget">
    <div class="block-fluid">
        <table cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th rowspan="2">
                    арт
                    <input id="articul" type="text" />
                </th>
                <th rowspan="2">
                    Наименование товара
                    <input id="name" type="text" />
                </th>
                <th colspan="7">
                    ФОТ Столярный участок
                </th>
                <th rowspan="2">
                    ФОТ Брус
                </th>
                <th colspan="4">
                    ФОТ Металлообработки
                </th>
                <th rowspan="2">
                    Действия
                </th>
            </tr>
            <tr>
                <th>
                    <i>Фрезеровка</i>
                </th>
                <th>
                    <i>Шлифовка</i>
                </th>
                <th>
                    <i>Грунтовка</i>
                </th>
                <th>
                    <i>Покраска</i>
                </th>
                <th>
                    <i>Лак</i>
                </th>
                <th>
                    <i>Сборка</i>
                </th>
                <th>
                    <i>Упаковка и маркировка</i>
                </th>
                <th>
                    <i>Сварка</i>
                </th>
                <th>
                    <i>Слесарка</i>
                </th>
                <th>
                    <i>Малярные работы</i>
                </th>
                <th>
                    <i>Упаковка и маркировка</i>
                </th>

            </tr>
            </thead>
            <tbody id='mainBody'>
            <?php
            foreach($model as $item)
            {
            ?>
            <tr>
                <td>
                    <?=$item->articul?>
                </td>
                <td>
                    <?=$item->name?>
                </td>
                <?php
                $price = ProductsPrices::model()->findByAttributes(array('product_id'=>$item->id));
                if ($price == NULL)
                    for($i=1;$i<=12;$i++)
                    {
                        echo "<td>
                              </td>";
                    }
                else
                {
                ?>
                    <td>
                        <?=$price->milling?>
                    </td>
                    <td>
                        <?=$price->polishing?>
                    </td>
                    <td>
                        <?=$price->first_coat?>
                    </td>
                    <td>
                        <?=$price->painting?>
                    </td>
                    <td>
                        <?=$price->varnish?>
                    </td>
                    <td>
                        <?=$price->assembling?>
                    </td>
                    <td>
                        <?=$price->packing_joiner?>
                    </td>
                    <td>
                        <?=$price->cant?>
                    </td>
                    <td>
                        <?=$price->weldment?>
                    </td>
                    <td>
                        <?=$price->metalwork?>
                    </td>
                    <td>
                        <?=$price->painting_metal?>
                    </td>
                    <td>
                        <?=$price->packing_metal?>
                    </td>

                <?php
                }
                ?>
                <td>
                    <div class="buttons">
                        <a href="/catalog/page/<?=$_GET['page']?>/<?=$item->id?>"
                        <button class="btn btn-mini"><span class="icon-edit"></span></button>
                        </a>
                        </button>
                    </div>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
    <?php

    $this->widget('CLinkPager', array(
        'pages' => $pages,
        'header' => '',
        'prevPageLabel'=>'&lt;',
        'nextPageLabel'=>'>',
        'cssFile' => Yii::app()->request->baseUrl."/css/pager.css",
    ))
    ?>
</div>
<?php
    if (isset($_GET['id']))
    {
        $this->renderPartial('_form',array('model'=>$priceModel));
    }
/*$prices = ProductsPrices::model()->findAll();
foreach($prices as $price)
{
    foreach($price as $key=>$row)
    {
        if ($key != 'id' && $key != 'product_id')
            if (is_numeric($price->$key))
                $price->$key = round($price->$key,2);

    }
    $price->save();
}*/
?>
<script src="/js/pages/catalog.js"></script>