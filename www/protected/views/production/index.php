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
    </div>
    <button class="btn" data-bind="visible: active_page_tab() == 2, click: calculate_dates">Рассчитать</button>
    <div class="right-buttons" style="margin-right: 30px;">
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
                <li><a class="printAllOrders">Выделить все</a></li>
                <li><a class="printAllOrders">Выбрать нужное</a></li>
                <li><a class="print">Печать выбранного</a></li>
            </ul>
        </div>

    </div>
</header>

<div id="calendar_tab" data-bind="visible: active_page_tab()==2 && !init_loading()">
    <div class="calendar-summary-container">
        <div class="row row-header">
            <div class="cell cell-total"><span>Сумма отгруж. товара</span></div>
            <div class="cell cell-average"><span>Ср. значение<span></div>
        </div>
        <div class="calendar-summary-rows">

        </div>
    </div>
    <div id="full_calendar"
         data-bind="fullCalendar: {events: calendar_events, eventClick: $root.edit_order_click}, visible: active_page_tab()==2">
    </div>
</div>
<form method="POST" action="/production/print" id="printForm">
    <div data-bind="visible: active_page_tab() != 2">
        <div class="no-orders" data-bind="visible: !init_loading() && filtered_orders().length == 0">Нет заказов
        </div>

        <div class="orders-container" data-bind="visible: !init_loading(), foreach: filtered_orders">
            <article data-bind="css: {'opened': opened}">
                <header>
                    <table>
                        <tbody>
                        <tr data-bind="css: {'red-line': App.Helper.daysBeetween(fact_shipping_date(), new Date()) < -7, 'gray-line': is_shipped()}">
                            <td class="cell-date"
                                data-bind="css: {'orange': fact_shipping_date().getMonth() != $root.page_month().getMonth() || fact_shipping_date().getFullYear() != $root.page_month().getFullYear(), 'rev': App.Helper.dateToStr(fact_shipping_date())!=1}">
                                <button class="btn btn-mini btn-hide" data-bind="click: toggle_open"><span
                                        class="icon-minus-sign"></span></button>
                                <button class="btn btn-mini btn-open" data-bind="click: toggle_open"><span
                                        class="icon-plus-sign"></span></button>
                                    <span class="date">
									
										<span class="date-wr"
                                              onclick="if($(this).parents('tr').hasClass('gray-line')) return;$(this).next().show().datepicker('show'); $(this).hide();">
											<span
                                                data-bind="text: shipping_date_str, css: {'none':App.Helper.dateToStr(fact_shipping_date()) != App.Helper.dateToStr(shipping_date())}"></span><br>
											<span class="day"
                                                  data-bind="text: shipping_date_day_str, css: {'none':App.Helper.dateToStr(fact_shipping_date()) != App.Helper.dateToStr(shipping_date())}"></span>
										</span>
										
										<input type="text"
                                               data-bind="datepicker: shipping_date, datepickerOptions: {onSelect: function(){App.DataPoint.UpdateShippingDate(id, $(this).datepicker('getDate')); $(this).trigger('change');}, onClose: function(){$(this).hide();$(this).prev().show();}}"
                                               style="display: none">
										
										
										
										<button class="dateBtn btn btn-mini"
                                                data-bind="text: shipping_date_str, css: {'none':App.Helper.dateToStr(fact_shipping_date()) == App.Helper.dateToStr(shipping_date())}"></button>
                                        <div class="dataModal">
                                            <span style="display: none" class="getId" data-bind="text: id"></span>

                                            <span
                                                data-bind="text: 'Расчетная дата «' + App.Helper.dateToStr(fact_shipping_date()) + '», заменить?'"></span><br>
                                            <button class="replaceIt btn btn-mini">Да</button>
                                        </div>

                                    </span>
                            </td>
                            <td class="cell-name">
                                    <span class="name">Заказ № <span data-bind="text: id"
                                                                     class="order_id"></span> от <span
                                            data-bind="text: date_str" class="orderDate"></span></span>

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
                            <td class="cell-buttons">
                                <div class="buttons">

                                    <button class="btn btn-mini" data-bind="click: $root.edit_order_click">
                                        <span class="icon-edit"></span>
                                    </button>

                                    <button class="btn btn-mini btn-comment"
                                            data-bind="css: {'filled': comment().length > 0}">
                                        <span class="icon-info-sign"></span>
                                    </button>

                                    <div class="btn-group">
                                        <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown"><span
                                                class="icon-asterisk"></span></button>

                                        <ul class="dropdown-menu">
                                            <li data-bind="visible: status() == 0"><a
                                                    data-bind="click: function($data){$root.change_status(this, 1);}"
                                                    href="#">В работу</a></li>
                                            <li data-bind="visible: status() == 0"><a href="#" data-bind="click: $root.delete_order">Удалить заказ</a>
                                            </li>
                                            <li data-bind="visible: status() != 0"><a href="#"
                                                                                      data-bind="click: function($data){$root.change_status(this, 0);}">Отменить
                                                    заказ</a>
                                            </li>
                                            <li data-bind="visible: status() != 0"><a href="#" data-bind="attr: {href: '/production/index/done/' + id}">Отгрузка</a></li>
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
                            <td class="print-buttons" style="display: none; width: 100px;">
                                Напечатать? <input name="printArr[]" type="checkbox" class="checkPrint"
                                                   data-bind="value: id"/>
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
                            data-bind="css:{'marked': state_1},click: function(data, event){$root.change_state(1, data)}"></td>
                        <td class="cell-status"
                            data-bind="css:{'marked': state_2},click: function(data, event){$root.change_state(2, data)}"></td>
                        <td class="cell-status"
                            data-bind="css:{'marked': state_3},click: function(data, event){$root.change_state(3, data)}"></td>
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
<?
if (isset($_GET['done'])) {
    $order = Order::model()->findByPk((int)$_GET['done']);
    $this->renderPartial('_done_form', array('id' => (int)$_GET['done'], 'order' => $order));
}
?>

<script src="/js/components/calendar.js"></script>
<script src="/js/pages/production.js"></script>