<div id="page" data-bind="css: {'no-sidebar': !hasSidebar()}">
<aside>
    <a href="#" class="btn btn-success btn-new-order" id="btn_new_order"
       data-bind="click: new_order_click, css: {'disabled': init_loading}">Новый заказ</a>

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

    <section class="categories-block" data-bind="visible: active_page_tab() != 3">
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

        <input type="text" placeholder="Поиск" class="search-input" data-bind="value: search_keyword, visible: active_page_tab() == 1 || active_page_tab() == 3">

    </div>
    <button class="btn" data-bind="visible: active_page_tab() == 2, click: calculate_dates">Рассчитать</button>
    <div class="right-buttons">
        <button class="btn"
                data-bind="click: toggle_all, visible: filtered_orders().length > 0 && active_page_tab() != 2"><span
                class="icon-minus-sign"></span> <span class="icon-plus-sign"></span>
            Свернуть/Развернуть всё
        </button>
        <div class="btn-group">
            <button class="btn dropdown-toggle" data-toggle="dropdown"
                    data-bind="visible: (active_page_tab() == 2 || filtered_orders().length > 0)"><span
                    class="icon-print"></span>
                Печать
            </button>
            <ul class="dropdown-menu">
                <li><a class="printAllOrders" data-bind="click: doPrint">Печать</a></li>
                <li><a class="printAllOrders"
                       data-bind="visible: print_mode() == 0, click: function(){$root.print_mode(1)}">Выборочная
                        печать</a></li>
                <li><a class="print" data-bind="visible: print_mode() == 1, click: function(){$root.print_mode(0);}">Отмена</a>
                </li>
            </ul>
        </div>

    </div>
</header>

<div id="calendar_tab" data-bind="visible: active_page_tab()==2 && !init_loading()">
    <div class="calendar-summary-container">
        <div class="row row-header">
        </div>
        <div class="calendar-summary-rows">

        </div>
    </div>
    <div id="full_calendar"
         data-bind="fullCalendar: {events: calendar_events}, visible: active_page_tab()==2">
    </div>
</div>
<form method="POST" action="/production/print" id="printForm">
    <div data-bind="visible: active_page_tab() != 2">
        <div class="no-orders" data-bind="visible: !init_loading() && filtered_orders().length == 0">Нет заказов
        </div>

        <div class="orders-container" data-bind="visible: !init_loading(), foreach: filtered_orders">
            <article data-bind="attr: {'data-id': id}, css: {'opened': opened}" class="order-article">
                <header>
                    <table>
                        <tbody>
                        <tr data-bind="click: function(data, event){if(event.target.tagName != 'BUTTON' && event.target.tagName != 'A' && event.target.tagName != 'INPUT' && $(event.target).parents('button, a').length === 0)$root.select_order(data); return true;},css: {'selected': is_selected, 'red-line': App.Helper.daysBeetween(fact_shipping_date(), new Date()) < -7, 'gray-line': is_shipped(), 'orange-line': App.Helper.dateToStr(fact_shipping_date()) != App.Helper.dateToStr(shipping_date())}">
                            <td class="cell-date"
                                data-bind="css: {'orange': fact_shipping_date().getMonth() != $root.page_month().getMonth() || fact_shipping_date().getFullYear() != $root.page_month().getFullYear(), 'rev': App.Helper.dateToStr(fact_shipping_date())!=1}">
                                <button class="btn btn-mini btn-hide" data-bind="click: toggle_open"><span
                                        class="icon-minus-sign"></span></button>
                                <button class="btn btn-mini btn-open" data-bind="click: toggle_open"><span
                                        class="icon-plus-sign"></span></button>
                                    <span class="date">
									
										<span class="date-wr">
											<span
                                                data-bind="text: shipping_date_str"></span><br>
											<span class="day"
                                                  data-bind="text: shipping_date_day_str"></span>
										</span>

										<!--<button class="dateBtn btn btn-mini"
                                                data-bind="text: shipping_date_str, css: {'none':App.Helper.dateToStr(fact_shipping_date()) == App.Helper.dateToStr(shipping_date())}"></button>-->
                                        <div class="dateModal"
                                             data-bind="css: {'need-show': is_shipped() == false && App.Helper.dateToStr(fact_shipping_date()) != App.Helper.dateToStr(shipping_date())}">
                                            <span style="display: none" class="getId" data-bind="text: id"></span>

                                            <span
                                                data-bind="text: 'Расчетная дата «' + App.Helper.dateToStr(fact_shipping_date()) + '», заменить?'"></span><br>
                                            <button class="replaceIt btn btn-mini">Да</button>
                                        </div>

                                    </span>
                            </td>
                            <td class="cell-name">

                                <span class="name">

                                    <span data-bind="visible: !order_str_edit_mode()" class="name">Заказ № <span
                                            data-bind="text: id"></span> (<span
                                            data-bind="text: order_str"
                                            class="order_id"></span>)
                                    <a href="#"
                                       data-bind="click: function(data, event){$root.toggleOrderOrder(data, -1, event);}"
                                       class="btn btn-mini"><span class="icon-arrow-up"></span></a>
                                    <a href="#" data-bind="click: toggle_order_str_edit" class="btn btn-mini"><span
                                            class="icon-certificate"></span></a>
                                    <a href="#"
                                       data-bind="click: function(data, event){$root.toggleOrderOrder(data, 1, event);}"
                                       class="btn btn-mini"><span class="icon-arrow-down"></span></a>
                                </span>

                                <div class="order_str-edit-container" data-bind="visible: order_str_edit_mode">
                                    <input type="text" data-bind="value: order_str" maxlength="9">
                                    <a href="#"
                                       data-bind="click: function(data, event){data.saveOrder($(event.target).parents('.order_str-edit-container').first().find('input').val())}"
                                       class="btn btn-mini"><span class="icon-ok-sign"></span></a>
                                    <a href="#" data-bind="click: toggle_order_str_edit" class="btn btn-mini"><span
                                            class="icon-remove"></span></a>
                                </div>

                                <span class="date">Дата начала производства: <span class="val"
                                                                                   data-bind="text: App.Helper.dateToStr(date())"></span></span>
                                <span class="date">Рассчетная дата отгрузки: <span class="val"
                                                                                   data-bind="text: App.Helper.dateToStr(fact_shipping_date())"></span></span>

                                <div class="progress">
                                    <div class="progress-value"
                                         data-bind="style: {width: progress_percent() + '%'}"><span
                                            data-bind="text: progress_text"></span></div>
                                </div>
                            </td>
                            <td class="cell-customer">
                                    <span
                                        data-bind="text: customer_text, tooltip: {title: customer_tooltip, html: true}"></span>
                            </td>
                            <td class="cell-price" data-bind="text: App.Helper.formatMoney(price())"></td>
                            <td class="cell-comment">
                                    <span
                                        data-bind="text: install_text, tooltip: {title: install_tooltip, html: true }"></span>
                            </td>
                            <td class="cell-buttons" data-bind="visible: $root.print_mode() == 0">
                                <div class="buttons">

                                    <button class="btn btn-mini"
                                            data-bind="click: $root.edit_order_click, visible: is_shipped() == false">
                                        <span class="icon-edit"></span>
                                    </button>

                                    <button class="btn btn-mini btn-comment"
                                            data-bind="css: {'filled': comment().length > 0}">
                                        <span class="icon-info-sign"></span>
                                    </button>

                                    <div class="btn-group" data-bind="visible: is_shipped() == false">
                                        <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown"><span
                                                class="icon-asterisk"></span></button>

                                        <ul class="dropdown-menu">
                                            <li data-bind="visible: status() == 0"><a
                                                    data-bind="click: function($data){$root.change_status(this, 1);}"
                                                    href="#">В работу</a></li>
                                            <li data-bind="visible: status() == 0"><a href="#"
                                                                                      data-bind="click: $root.delete_order">Удалить
                                                    заказ</a>
                                            </li>
                                            <li data-bind="visible: status() != 0"><a href="#"
                                                                                      data-bind="click: function($data){$root.change_status(this, 0);}">Отменить
                                                    заказ</a>
                                            </li>
                                            <li data-bind="visible: status() != 0"><a href="#"
                                                                                      data-bind="attr: {href: '/production/index/done/' + id}">Отгрузка</a>
                                            </li>
                                            <!--<li><a href="#"
                                                   data-bind="text: name, value: id, css:{'selected': 0 && id == $parent.status()}, click: function(data){$root.change_status($parent, id);}"></a>
                                            </li>
                                            -->
                                        </ul>

                                    </div>
                                </div>
                                <input type="text" class="comment-editable"
                                       data-bind="editable: comment, editableOptions: {type: 'textarea', placement:'left', name: 'comment', emptytext:'&nbsp;', pk: id, url: '/orders/SaveOrderComment'}">

                            </td>
                            <td class="print-buttons" data-bind="visible: $root.print_mode() == 1">
                                <input type="checkbox" data-bind="checked: need_print"/>
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
                        <td class="cell-articul" data-bind="text: product() ? product().articul : ''"></td>
                        <td class="cell-name" data-bind="text: product() ? product().name : ''"></td>
                        <td class="cell-count" data-bind="text: count"></td>
                        <td class="cell-count done" data-bind="text: done"></td>
                        <td class="cell-comment"><span
                                data-bind="editable: comment, editableOptions: {name: 'comment', emptytext:'&nbsp;', pk: id, url: '/orders/SaveComment'}"></span>
                        </td>
                        <td class="cell-status"
                            data-bind="css:{'marked': state_1},click: function(data, event){if(data.is_shipped() == false)$root.change_state(1, data)}"></td>
                        <td class="cell-status"
                            data-bind="css:{'marked': state_2},click: function(data, event){if(data.is_shipped() == false)$root.change_state(2, data)}"></td>
                        <td class="cell-status"
                            data-bind="css:{'marked': state_3},click: function(data, event){if(data.is_shipped() == false)$root.change_state(3, data)}"></td>
                    </tr>

                    </tbody>
                </table>
            </article>

        </div>
    </div>
</form>
</section>

</div>

<? $this->renderPartial('_order_form'); ?>
<? $this->renderPartial('_date_form'); ?>
<? $this->renderPartial('_order_products_modal'); ?>
<? $this->renderPartial('_order_change_order_modal'); ?>

<?
if (isset($_GET['done'])) {
    $order = Order::model()->findByPk((int)$_GET['done']);
    $this->renderPartial('_done_form', array('id' => (int)$_GET['done'], 'order' => $order));
}
?>

<script src="/js/components/calendar.js"></script>
<script src="/js/pages/production.js"></script>