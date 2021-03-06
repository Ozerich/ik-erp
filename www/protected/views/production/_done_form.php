<style>
    form {
        margin: 0;
    }

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
        width: 98%;
        margin: 5px auto 12px;
    }

    table.orders td {
        border: 1px solid #cdcdcd;
        background: #fdfdfd;
        padding: 4px;
    }

    table.orders tr.done td {
        color: #d3d3d3;
    }

    table.orders tr.done input{
        color: #000;
    }

    table.orders th {
        border: 1px solid #cdcdcd;
        line-height: 26px;
        padding: 0 12px;
        color: #333333;
        display: table-cell;
        vertical-align: inherit;
    }
</style>
<?php
$factDate = intval($order->shipping_date[8] . $order->shipping_date[9]);
$date = $order->date[8] . $order->date[9];
$factDateArr = explode('-', $order->shipping_date);
$week = date("w", mktime(0, 0, 0, $factDateArr[1], $factDateArr[2], $factDateArr[0]));
$month = (int)($factDateArr[1]);
$price = 0;
$count = 0;

foreach ($order->order_products as $item) {
    $price += $item->count * $item->product->price;
    $count += $item->count;
}
$done = true;
$maxDone = 0;
$dateArr = array();
foreach ($order->order_products as $item) {
    foreach ($item->done as $i) {
        if (!in_array($i->date, $dateArr)) {
            $dateArr[] = $i->date;
        }
    }

    if (OrdersDone::getDoneForProduct($item->order_id, $item->product_id) < $item->count) {
        $done = false;
    }

    if ($maxDone < count($item->done)) {
        $maxDone = count($item->done);
    }
}

$done = $order->isShipped;
?>
<div id="done_form" class="modal" role="dialog" style="display: none">
    <form method="POST">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Отрузка заказа №<?=$order->id?></h3>
        </div>

        <div class="row-fluid">

            <table class="doneForm">
                <tbody>
                <tr>
                    <td class="cell-date" style="text-align: center">
                <span class="date"><span><?=$factDate?><br><?=$this->getMonthForTable($month)?></span><br><span
                        class="day"><?=$this->getDayForTable($week)?></span></span>

                    </td>
                    <td class="cell-name">
                    <span class="name">Заказ № <?=$order->id?>
                        от <?=$date . " " . $this->getMonthForTable($month)?></span>

                    </td>
                    <td class="cell-customer">
                        <span><?=$this->getDivision($order->division)?></span>
                    </td>
                    <td class="cell-price"><?=$price?></td>
                    <td class="cell-comment">
                    <span>
                        <?php
                        if ($order->need_install)
                            echo 'Монтаж: ' . $order->install_address;
                        else
                            echo 'Самовывоз';
                        ?>
                    </span>
                    </td>
                </tr>
                </tbody>
            </table>


            <input type="hidden" name="order_id" value="<?= $order->id ?>">
            <table class="orders">
                <thead>
                <tr>
                    <th class="cell-articul">Арт.</th>
                    <th class="cell-name">Наименование</th>
                    <th class="cell-count">Кол-во</th>
                    <?php
                    foreach ($dateArr as $date) {
                        echo '<th class="cell-count">Отгружено ' . $date . '</th>';
                    }
                    if (!$done)
                        echo '<th class="cell-count">Отгрузить ' . date('d.m') . '</th>';
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($order->order_products as $item):
                    $doneCount = OrdersDone::getDoneForProduct($item->order_id, $item->product_id);
                    ?>
                    <tr<?=(($item->count <= $doneCount) ? " class='done'" : (($doneCount > 0) ? " class='donePart'" : ""))?>>
                        <td><?=$item->product->articul?></td>
                        <td><?=$item->product->name?></td>
                        <td><?=$item->count?></td>
                        <?php
                        foreach ($dateArr as $date) {
                            $hasDone = OrdersDone::model()->findByAttributes(array('date' => $date, 'order_id' => $order->id, 'product_id' => $item->product_id));
                            if ($hasDone == NULL)
                                $hasDone = 0;
                            else
                                $hasDone = $hasDone->done;
                            echo '<td class="cell-count">' . $hasDone . '</td>';
                        }
                        if (!$done) {
                            $hasDone = OrdersDone::model()->findByAttributes(array('date' => date('d.m'), 'order_id' => $order->id, 'product_id' => $item->product_id));
                            if ($hasDone == NULL)
                                $hasDone = 0;
                            else
                                $hasDone = $hasDone->done;
                            if ($item->count <= $doneCount)
                                echo '<td class="active cell-count"><input type="text" disabled="disabled" /></td>';
                            else
                                echo '<td class="active cell-count"><input type="text" name="doneArr[' . $item->product_id . ']" value="' . $hasDone . '" /></td>';
                        }
                        ?>
                    </tr>
                <?php
                endforeach;
                ?>

                </tbody>
            </table>
        </div>
        <div class="modal-footer">

            <input type="submit" name="submit" class="btn btn-primary" value="Отгрузить">
            <button id="closeForm" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                Закрыть
            </button>
        </div>

    </form>
</div>
<script>
    $(function () {$('#done_form').modal();})
</script>