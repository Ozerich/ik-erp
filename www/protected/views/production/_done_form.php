<style>
    table.doneForm td {
        margin-top: 1px;
        border-top: 1px solid #378fb8;
        border-right: 1px solid #215672;
        border-left: 1px solid #378fb8;
        background: #2a6d90;
        height: 46px;
        padding: 0 15px;
        color: #ffffff;
    }

    table.orders {
        border-collapse: collapse;
        background: #dddddd;
        margin-bottom: 12px;
    }

    table.orders td {
        border: 1px solid #cdcdcd;
        background: #fdfdfd;
        padding: 4px;
    }

    table.orders tr.done td{
        background: orange;
    }

    table.orders tr.donePart td{
        background: gray;
    }

    table.orders td.active{
        background: green;
    }


    table.orders th {
        border: 1px solid #fdfdfd;
        line-height: 26px;
        padding: 0 12px;
        color: #333333;
        display: table-cell;
        vertical-align: inherit;
    }
</style>
<?php
$factDate = intval($order->shipping_date[8].$order->shipping_date[9]);
$date = $order->date[8].$order->date[9];
$factDateArr = explode('-',$order->shipping_date);
$week = date("w",mktime (0, 0, 0, $factDateArr[1], $factDateArr[2], $factDateArr[0]));
$month = (int)($factDateArr[1]);
$price = 0;
$count = 0;

foreach($order->order_products as $item)
{
    $price += $item->count * $item->product->price;
    $count += $item->count;
}
$done = true;
$maxDone = 0;
$dateArr = array();
foreach($order->order_products as $item)
{
    if (OrdersDone::getDoneForProduct($item->order_id,$item->product_id) < $item->count)
        $done = false;
    if ($maxDone < count($item->done))
    {
        $maxDone = count($item->done);
        $dateArr = array();
        foreach($item->done as $i)
            $dateArr[] = $i->date;
    }
}
?>
<div id="order_form" class="modal" role="dialog"
    >
    <table class="doneForm">
        <tbody>
        <tr>
            <td class="cell-date" style="text-align: center">
                <span class="date"><span><?=$factDate?><br><?=$this->getMonthForTable($month)?></span><br><span class="day"><?=$this->getDayForTable($week)?></span></span>

            </td>
            <td class="cell-name">
                <span class="name">Заказ № <?=$order->id?> от <?=$date." ".$this->getMonthForTable($month)?></span>

            </td>
            <td class="cell-customer">
                <span><?=$this->getDivision($order->division)?></span>
            </td>
            <td class="cell-price"><?=$price?></td>
            <td class="cell-comment">
                                    <span>
                                        <?php
                                        if ($order->need_install)
                                            echo 'Монтаж: '.$order->install_address;
                                        else
                                            echo 'Самовывоз';
                                        ?>
                                    </span>
            </td>
        </tr>
        </tbody>
    </table>

<form method="POST">
    <input type="hidden" name="order_id" value="<?=$order->id?>">
    <table class="orders">
        <thead>
        <tr>
            <th class="cell-articul">Арт.</th>
            <th class="cell-name">Наименование</th>
            <th class="cell-count">Кол-во</th>
            <?php
            foreach($dateArr as $date)
            {
                if ($date === date('d.m'))
                    continue;
                echo '<th class="cell-count">Отгружено '.$date.'</th>';
            }
            if (!$done)
                echo '<th class="cell-count">Отгрузить '.date('d.m').'</th>';
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($order->order_products as $item):
            $doneCount = OrdersDone::getDoneForProduct($item->order_id,$item->product_id);
        ?>
        <tr<?=(($item->count == $doneCount)?" class='done'":(($doneCount>0)?" class='donePart'":""))?>>
            <td><?=$item->product->articul?></td>
            <td><?=$item->product->name?></td>
            <td><?=$item->count?></td>
            <?php
            foreach($dateArr as $date)
            {
                if ($date === date('d.m'))
                    continue;
                $hasDone = OrdersDone::model()->findByAttributes(array('date'=>$date,'order_id'=>$order->id,'product_id'=>$item->product_id));
                if ($hasDone == NULL)
                    $hasDone = 0;
                else
                    $hasDone = $hasDone->done;
                echo '<td class="cell-count">'.$hasDone.'</td>';
            }
            if (!$done)
            {
                $hasDone = OrdersDone::model()->findByAttributes(array('date'=>date('d.m'),'order_id'=>$order->id,'product_id'=>$item->product_id));
                if ($hasDone == NULL)
                    $hasDone = 0;
                else
                    $hasDone = $hasDone->done;
                if ($item->count == $doneCount)
                    echo '<td class="active cell-count"><input type="text" disabled="disabled" /></td>';
                else
                    echo '<td class="active cell-count"><input type="text" name="doneArr['.$item->product_id.']" value="'.$hasDone.'" /></td>';
            }
            ?>
        </tr>
        <?php
        endforeach;
        ?>

        </tbody>
    </table>
    <div class="modal-footer">
        <input type="submit" name="submit" class="btn btn-primary" value="Сохранить">
    </div>
</form>
</div>