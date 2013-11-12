<style>
    table.prices th {
        border-color: black !important;
    }

    .dateBlock {
        width: 200px;
        margin: 0 auto;
        text-align: center;
    }

    .month {
        font-weight: bold;
        margin: 0 20px;
        font-size: 14px;
    }
</style>
<div id="page">
    <section id="content" style="margin-left: 0px;">
        <header>
            <div class="dateBlock">
                <?php
                echo CHtml::link('', array('index', 'month' => $month - 1, 'year' => $year), array('class' => 'arrow-left icon-chevron-left', 'style' => 'float:left;'));
                echo '<span class="month">' . $this->getMonth($month) . ' ' . $year . '</span>';
                echo CHtml::link('', array('index', 'month' => $month + 1, 'year' => $year), array('class' => 'arrow-right icon-chevron-right', 'style' => 'float:right;'));
                ?>
            </div>

            <div class="right-buttons" style="margin-top: -25px;">

                <button class="btn showHide">
                    Свернуть/Развернуть всё
                </button>
                <div class="btn-group">
                    <button class="btn dropdown-toggle" data-toggle="dropdown"><span
                            class="icon-print"></span>
                        Печать
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="doPrint">Печать</a></li>
                        <li><a class="printChecked">Выборочная печать</a></li>
                        <li><a class="printCancel" style="display: none">Отмена</a>
                        </li>
                    </ul>
                </div>

            </div>


        </header>
        <div>
            <?php
            if (!$orders) {
                ?>
                <div class="no-orders">Нет заказов
                </div>
            <?php
            } else {
                ?>
                <div class="orders-container" data-bind="visible: !init_loading(), foreach: filtered_orders">
                    <?php
                    foreach ($orders as $order) {
                        $factDate = intval($order->shipping_date[8] . $order->shipping_date[9]);
                        $date = $order->date[8] . $order->date[9];
                        $factDateArr = explode('-', $order->shipping_date);
                        $week = date("w", mktime(0, 0, 0, $factDateArr[1], $factDateArr[2], $factDateArr[0]));
                        $price = 0;
                        $count = 0;
                        foreach ($order->order_products as $item) {
                            $price += $item->count * $item->product->price;
                            $count += $item->count;
                        }
                        ?>
                        <article data-id="<?=$order->id?>">
                            <header>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="cell-date">
                                            <button class="btn btn-mini btn-hide" data-bind="click: toggle_open"><span
                                                    class="icon-minus-sign"></span></button>
                                            <button class="btn btn-mini btn-open" data-bind="click: toggle_open"><span
                                                    class="icon-plus-sign"></span></button>
                                    <span class="date"><span><?= $factDate ?><br><?= $this->getMonthForTable($month) ?></span><br><span
                                            class="day"
                                            ><?= $this->getDayForTable($week) ?></span></span>
                                        </td>
                                        <td class="cell-name">
                                            <span class="name">Заказ № <?= $order->id ?>
                                                от <?= $date . " " . $this->getMonthForTable($month) ?></span>

                                        </td>
                                        <td class="cell-customer">
                                            <span><?= $this->getDivision($order->division) ?></span>
                                        </td>
                                        <td class="cell-price"><?= $price ?></td>
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
                                        <td style="display: none;" class="print-buttons"
                                            data-bind="visible: $root.print_mode() == 1">
                                            <input type="checkbox" data-bind="checked: need_print"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </header>
                            <table class='prices'>
                                <thead>
                                <tr>
                                    <th class="cell-articul" rowspan="2" style="background: #c6be97;">Арт.</th>
                                    <th class="cell-name" rowspan="2" style="background: #c6be97;">Наименование</th>
                                    <th class="cell-count" rowspan="2" style="background: #c6be97;">Кол-во</th>
                                    <th class="cell-name" colspan="8" style="background: #dcba9d;">ФОТ Столярный
                                        участок
                                    </th>
                                    <th class="cell-name" rowspan="2" style="background: #d9e5bd;">ФОТ Брус</th>
                                    <th class="cell-name" colspan="5" style="background: #b8cce4;">ФОТ
                                        Металлообработки
                                    </th>
                                </tr>
                                <tr>
                                    <th class="cell-name" style="background: #dcba9d;">Сумма</th>
                                    <th class="cell-name" style="background: #dcba9d;">Фрезеровка</th>
                                    <th class="cell-name" style="background: #dcba9d;">Шлифовка</th>
                                    <th class="cell-name" style="background: #dcba9d;">Грунтовка</th>
                                    <th class="cell-name" style="background: #dcba9d;">Покраска</th>
                                    <th class="cell-name" style="background: #dcba9d;">Лак</th>
                                    <th class="cell-name" style="background: #dcba9d;">Сборка</th>
                                    <th class="cell-name" style="background: #dcba9d;">Упаковка и маркировка</th>
                                    <th class="cell-name" style="background: #b8cce4;">Сумма</th>
                                    <th class="cell-name" style="background: #b8cce4;">Сварка</th>
                                    <th class="cell-name" style="background: #b8cce4;">Слесарка</th>
                                    <th class="cell-name" style="background: #b8cce4;">Малярные работы</th>
                                    <th class="cell-name" style="background: #b8cce4;">Упаковка и маркировка</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sumPrices = array();
                                $sum1All = $sum2All = 0;
                                foreach ($order->order_products as $product) {
                                    ?>
                                    <tr>
                                        <td class="cell-articul"><?= $product->product->articul ?></td>
                                        <td class="cell-articul"><?= $product->product->name ?></td>
                                        <td class="cell-articul"><?= $product->count ?></td>
                                        <?php
                                        $prices = ProductsPrices::model()->findByAttributes(array('product_id' => $product->id));
                                        if ($prices == NULL)
                                            for ($i = 1; $i <= 14; $i++)
                                                echo '<td class="cell-articul">0</td>';
                                        else {
                                            $prices->getSums();
                                            echo '<td class="cell-articul"  style="background: #dcba9d;">' . $prices->sum1 . '</td>';
                                            $sum1All += $prices->sum1;
                                            $sum2All += $prices->sum2;
                                            foreach ($prices as $key => $value) {
                                                if ($key == 'weldment')
                                                    echo '<td class="cell-articul"  style="background: #b8cce4;">' . $prices->sum2 . '</td>';
                                                if ($key != 'id' && $key != 'product_id') {
                                                    echo '<td class="cell-articul"' . (($key == 'cant') ? ' style="background: #d9e5bd;"' : '') . '>' . $value . '</td>';
                                                    if (!isset($sumPrices[$key]))
                                                        $sumPrices[$key] = 0;
                                                    $sumPrices[$key] += $value;
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td class="cell-articul"></td>
                                    <td class="cell-articul"></td>
                                    <td class="cell-articul"><?= $count ?></td>
                                    <td class="cell-articul" style="background: #dcba9d;"><?= $sum1All ?></td>
                                    <?php
                                    $background = '#dcba9d';
                                    foreach ($sumPrices as $key => $value) {
                                        if ($key == 'cant')
                                            $background = '#d9e5bd';
                                        elseif ($key == 'weldment') {
                                            $background = '#b8cce4';
                                            echo '<td class="cell-articul" style="background: ' . $background . '">' . $sum2All . '</td>';
                                        }
                                        echo '<td class="cell-articul" style="background: ' . $background . '">' . $value . '</td>';
                                    }
                                    ?>
                                </tr>
                                </tbody>
                            </table>
                        </article>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>

    </section>

</div>
<script src="/js/pages/payments.js"></script>