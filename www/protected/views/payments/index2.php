<div id="page">
    <section id="content" style="margin-left: 0px;">

        <div id="page_loader" data-bind="visible: init_loading"><img src="/img/loaders/1d_6.gif"></div>


        <header data-bind="visible: !init_loading() && (active_page_tab() == 2 || filtered_date_orders().length > 0)">
            <div class="btn-group">
                <button type="button" class="btn"
                        data-bind="css: {'active': active_page_tab() == 1}, click: function(){change_tab(1);}">В работе
                </button>
                <button type="button" class="btn"
                        data-bind="css: {'active': active_page_tab() == 2}, click: function(){change_tab(2);}">Сетевой
                    вид
                </button>
                <button type="button" class="btn"
                        data-bind="css: {'active': active_page_tab() == 3}, click: function(){change_tab(3);}">На
                    рассмотрении
                </button>
            </div>
            <button class="btn" data-bind="visible: active_page_tab() == 2, click: calculate_dates">Рассчитать</button>
            <div class="right-buttons">
                <button class="btn"
                        data-bind="click: toggle_all, visible: filtered_orders().length > 0 && active_page_tab() != 2"><span
                        class="icon-minus-sign"></span> <span class="icon-plus-sign"></span>
                    Свернуть/Развернуть всё
                </button>
                <button class="btn" data-bind="visible: (active_page_tab() == 2 || filtered_orders().length > 0)"><span
                        class="icon-print"></span>
                    Печать
                </button>
            </div>
        </header>

        <div data-bind="visible: active_page_tab() != 2">
            <?php
            if ($orders == NULL)
            {
            ?>
            <div class="no-orders">Нет заказов
            </div>
            <?php
            }
            else
            {
            ?>
            <div class="orders-container" data-bind="visible: !init_loading(), foreach: filtered_orders">
                <?php
                foreach($orders as $order)
                {
                    $factDate = intval($order->shipping_date[8].$order->shipping_date[9]);
                    $date = $order->date[8].$order->date[9];
                    $factDateArr = explode('-',$order->shipping_date);
                    $week = date("w",mktime (0, 0, 0, $factDateArr[1], $factDateArr[2], $factDateArr[0]));
                    $price = 0;
                    foreach($order->order_products as $item)
                    {
                        $price += $item->count * $item->product->price;
                    }
                    ?>
                <article data-bind="css: {'opened': opened}">
                    <header>
                        <table>
                            <tbody>
                            <tr>
                                <td class="cell-date">
                                    <button class="btn btn-mini btn-hide" data-bind="click: toggle_open"><span
                                            class="icon-minus-sign"></span></button>
                                    <button class="btn btn-mini btn-open" data-bind="click: toggle_open"><span
                                            class="icon-plus-sign"></span></button>
                                    <span class="date"><span><?=$factDate?><br><?=$month?></span><br><span class="day"
                                                                                                        ><?=$this->getDayForTable($week)?></span></span>
                                </td>
                                <td class="cell-name">
                                    <span class="name">Заказ № <?=$order->id?> от <?=$date." ".$month?></span>

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
                                <td class="cell-buttons">
                                    <div class="buttons">
                                        <div class="btn-group">
                                            <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown"><span
                                                    class="icon-asterisk"></span></button>
                                            <ul class="dropdown-menu" data-bind="foreach: $root.statuses">
                                                <li><a href="#"
                                                       data-bind="text: name, css:{'selected': id == $parent.status()}, click: function(data){$root.change_status($parent, id);}"></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="text" class="comment-editable"
                                           data-bind="editable: comment, editableOptions: {type: 'textarea', placement:'left', name: 'comment', emptytext:'&nbsp;', pk: id, url: '/orders/SaveOrderComment'}">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </header>
                    <table>
                        <thead>
                        <tr>
                            <th class="cell-articul" rowspan="2">Арт.</th>
                            <th class="cell-name" rowspan="2">Наименование</th>
                            <th class="cell-count" rowspan="2">Кол-во</th>
                            <th class="cell-name" colspan="7">ФОТ Столярный участок</th>
                            <th class="cell-name" rowspan="2">ФОТ Брус</th>
                            <th class="cell-name" colspan="4">ФОТ Металлообработки</th>
                        </tr>
                        <tr>
                            <th class="cell-name">Фрезеровка</th>
                            <th class="cell-name">Шлифовка</th>
                            <th class="cell-name">Грунтовка</th>
                            <th class="cell-name">Покраска</th>
                            <th class="cell-name">Лак</th>
                            <th class="cell-name">Сборка</th>
                            <th class="cell-name">Упаковка и маркировка</th>
                            <th class="cell-name">Сварка</th>
                            <th class="cell-name">Слесарка</th>
                            <th class="cell-name">Малярные работы</th>
                            <th class="cell-name">Упаковка и маркировка</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($order->order_products as $product)
                        {
                        ?>
                        <tr>
                            <td class="cell-articul"><?=$product->product->articul?></td>
                            <td class="cell-articul"><?=$product->product->name?></td>
                            <td class="cell-articul"><?=$product->count?></td>
                            <?php
                            $prices = ProductsPrices::model()->findByAttributes(array('product_id'=>$product->id));
                            if ($prices == NULL)
                                for($i=1;$i<=12;$i++)
                                    echo '<td class="cell-articul">0</td>';
                            else
                                foreach($prices as $key=>$value)
                                {
                                    if ($key != 'id' && $key != 'product_id')
                                        echo '<td class="cell-articul">'.$value.'</td>';
                                }
                            ?>
                          </tr>
                        <?php
                        }
                        ?>
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