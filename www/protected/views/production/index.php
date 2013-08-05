<div id="page">
    <aside>
        <a href="#" class="btn btn-success btn-new-order" id="btn_new_order" data-bind="click: new_order_click, css: {'disabled': init_loading}">Новый заказ</a>

        <section class="calendar-block">
            <div id="calendar">
                <div class="calendar-header">
                    <a href="#" class="arrow-left icon-chevron-left"></a>
                    <a href="#" class="arrow-right icon-chevron-right"></a>
                    <span></span>
                </div>
                <div class="calendar-table">
                    <table>
                        <thead>
                        <tr>
                            <th><span>Пн</span></th>
                            <th><span>Вт</span></th>
                            <th><span>Ср</span></th>
                            <th><span>Чт</span></th>
                            <th><span>Пт</span></th>
                            <th><span>Сб</span></th>
                            <th><span>Вс</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="categories-block">
            <ul>
                <li><a href="#">В работе</a></li>
                <li><a href="#">Заказы на производство</a></li>
                <li><a href="#">Наряды в металл</a></li>
                <li><a href="#">Наряды в фанеру</a></li>
                <li><a href="#">Наряды на сборку</a></li>
                <li><a href="#">Наряды в брус</a></li>
                <li><a href="#">Ведомости к отругзке</a></li>
            </ul>
        </section>

    </aside>

    <section id="content">

        <div id="page_loader" data-bind="visible: init_loading"><img src="/img/loaders/1d_6.gif"></div>

        <div class="no-orders" data-bind="visible: !init_loading() && filtered_orders().length == 0">Нет заказов</div>

        <header data-bind="visible: !init_loading() && filtered_orders().length">
            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" class="btn active">Табличный вид</button>
                <button type="button" class="btn">Сетевой вид</button>
                <button type="button" class="btn">На рассмотрении</button>
            </div>
            <div class="right-buttons">
                <button class="btn" data-bind="click: toggle_all"><span class="icon-minus-sign"></span> <span class="icon-plus-sign"></span>
                    Свернуть/Развернуть всё
                </button>
                <button class="btn"><span class="icon-print"></span> Печать</button>
            </div>
        </header>

        <div class="orders-container" data-bind="visible: !init_loading(), foreach: filtered_orders">

                <article data-bind="css: {'opened': opened}">
                    <header>
                        <table>
                            <tbody>
                            <tr>
                                <td class="cell-date">
                                    <button class="btn btn-mini btn-hide" data-bind="click: toggle_open"><span class="icon-minus-sign"></span></button>
                                    <button class="btn btn-mini btn-open" data-bind="click: toggle_open"><span class="icon-plus-sign"></span></button>
                                    <span class="date"><span data-bind="text: date_str"></span><br><span class="day" data-bind="text: date_day_str"></span></span>
                                </td>
                                <td class="cell-name">
                                    <span class="name">Заказ № <span data-bind="text: id"></span> от <span data-bind="text: date_str"></span></span>

                                    <div class="progress">
                                        <div class="progress-value" data-bind="style: {width: progress_percent() + '%'}"><span data-bind="text: progress_percent"></span> %</div>
                                    </div>
                                </td>
                                <td class="cell-customer" data-bind="text: customer"></td>
                                <td class="cell-price" data-bind="text: price"></td>
                                <td class="cell-comment">
                                    Наш монтаж в СПб,
                                    Авиаконструкторов 2
                                </td>
                                <td class="cell-buttons">
                                    <button class="btn btn-mini"><span class="icon-edit"></span></button>
                                    <button class="btn btn-mini btn-info"><span class="icon-info-sign"></span></button>
                                    <button class="btn btn-mini"><span class="icon-asterisk"></span></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </header>
                    <table>
                        <thead>
                        <tr>
                            <th class="cell-articul">Арт.</th>
                            <th class="cell-name">Наименование</th>
                            <th class="cell-count">Кол-во</th>
                            <th class="cell-count">Отгружено</th>
                            <th class="cell-comment">Комментарии</th>
                            <th class="cell-status">Ф</th>
                            <th class="cell-status">М</th>
                            <th class="cell-status">Д</th>
                        </tr>
                        </thead>
                        <tbody data-bind="foreach: products">

                        <tr data-bind="css:{'yellow': comment().length > 0}">
                            <td class="cell-articul" data-bind="text: product().articul"></td>
                            <td class="cell-name" data-bind="text: product().name"></td>
                            <td class="cell-count" data-bind="text: count">1</td>
                            <td class="cell-count">0</td>
                            <td class="cell-comment" data-bind="text: comment"></td>
                            <td class="cell-status"></td>
                            <td class="cell-status"></td>
                            <td class="cell-status"></td>
                        </tr>

                        </tbody>
                    </table>
                </article>

        </div>
    </section>

</div>
<? $this->renderPartial('_order_form'); ?>

<script src="/js/components/calendar.js"></script>
<script src="/js/pages/production.js"></script>