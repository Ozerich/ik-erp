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

        <header data-bind="visible: !init_loading()">
            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" class="btn active">Табличный вид</button>
                <button type="button" class="btn">Сетевой вид</button>
                <button type="button" class="btn">На рассмотрении</button>
            </div>
            <div class="right-buttons">
                <button class="btn"><span class="icon-minus-sign"></span> <span class="icon-plus-sign"></span>
                    Свернуть/Развернуть всё
                </button>
                <button class="btn"><span class="icon-print"></span> Печать</button>
            </div>
        </header>

        <div class="orders-container" data-bind="visible: !init_loading()">
            <? for ($i = 0; $i < 10; $i++): ?>
                <article <?=$i % 3 == 0 ? 'class="opened"' : ''?>>
                    <header>
                        <table>
                            <tbody>
                            <tr>
                                <td class="cell-date">
                                    <button class="btn btn-mini btn-hide"><span class="icon-minus-sign"></span></button>
                                    <button class="btn btn-mini btn-open"><span class="icon-plus-sign"></span></button>
                                    <span class="date">22 июня<br><span class="day">пн</span></span>
                                </td>
                                <td class="cell-name">
                                    <span class="name">Заказ № 345 от 12.07.13</span>

                                    <div class="progress">
                                        <div class="progress-value" style="width: 45%">45%</div>
                                    </div>
                                </td>
                                <td class="cell-customer">
                                    “Красивый город”,
                                    Паршиков
                                </td>
                                <td class="cell-price">
                                    1 250 700
                                </td>
                                <td class="cell-comment">
                                    Наш монтаж в СПб,
                                    Авиаконструкторов 2
                                </td>
                                <td class="cell-buttons">
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
                        <tbody>
                        <tr>
                            <td class="cell-articul">3112</td>
                            <td class="cell-name">ИК “Кораблик” <strong>(на брусе)</strong></td>
                            <td class="cell-count">1</td>
                            <td class="cell-count">0</td>
                            <td class="cell-comment">Разработать</td>
                            <td class="cell-status"></td>
                            <td class="cell-status"></td>
                            <td class="cell-status"></td>
                        </tr>
                        <tr class="yellow">
                            <td class="cell-articul">3112</td>
                            <td class="cell-name">ИК “Кораблик” <strong>(на брусе)</strong></td>
                            <td class="cell-count">1</td>
                            <td class="cell-count">0</td>
                            <td class="cell-comment">Разработать</td>
                            <td class="cell-status marked"></td>
                            <td class="cell-status"></td>
                            <td class="cell-status marked"></td>
                        </tr>
                        <tr>
                            <td class="cell-articul">3112</td>
                            <td class="cell-name">ИК “Кораблик” <strong>(на брусе)</strong></td>
                            <td class="cell-count">1</td>
                            <td class="cell-count">0</td>
                            <td class="cell-comment">Разработать</td>
                            <td class="cell-status"></td>
                            <td class="cell-status marked"></td>
                            <td class="cell-status"></td>
                        </tr>
                        <tr>
                            <td class="cell-articul">3112</td>
                            <td class="cell-name">ИК “Кораблик” <strong>(на брусе)</strong></td>
                            <td class="cell-count">1</td>
                            <td class="cell-count">0</td>
                            <td class="cell-comment">Разработать</td>
                            <td class="cell-status marked"></td>
                            <td class="cell-status marked"></td>
                            <td class="cell-status marked"></td>
                        </tr>
                        <tr>
                            <td class="cell-articul">3112</td>
                            <td class="cell-name">ИК “Кораблик” <strong>(на брусе)</strong></td>
                            <td class="cell-count">1</td>
                            <td class="cell-count">0</td>
                            <td class="cell-comment">Разработать</td>
                            <td class="cell-status"></td>
                            <td class="cell-status marked"></td>
                            <td class="cell-status"></td>
                        </tr>
                        </tbody>
                    </table>
                </article>

            <? endfor; ?>
        </div>
    </section>

</div>
<? $this->renderPartial('_order_form'); ?>

<script src="/js/components/calendar.js"></script>
<script src="/js/pages/production.js"></script>