<div id="order_form" class="modal hide fade" aria-hidden="true"
     style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel" data-bind="text: id() ? 'Заказ №' + id() : 'Новый заказ'"></h3>
    </div>
    <div class="row-fluid">


        <div class="accordion">
            <h3>Параметры</h3>

            <div id="order_params">

                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span4">Дата размещения:</div>
                        <div class="span8">
                            <span data-bind="text: App.Helper.dateToStr(date())"></span>
                        </div>
                    </div>
                    <div class="row-form" data-bind="css: {'error': errors.shipping_date_error().length}">
                        <div class="span4">Планируемая дата отгрузки:</div>
                        <div class="span8">
                            <input type="text" class="datepicker" class="datepicker"
                                   data-bind="datepicker: shipping_date, datepickerOptions: { minDate: new Date() }">
                            <span data-bind="visible: id()">&nbsp;&nbsp;&nbsp;Рассчетная дата отгрузки:
                            <span data-bind="text: App.Helper.dateToStr(fact_shipping_date())"></span>
                                </span>
                            <span class="bottom" data-bind="text: errors.shipping_date_error()"></span>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Дистрибьютор:</div>
                        <div class="span8">
                            <select
                                data-bind="options: divisions, value: division, optionsValue: 'id', optionsText: 'name'"></select>
                        </div>
                    </div>
                    <div class="row-form" data-bind="css: {'error': errors.worker_error().length}">
                        <div class="span4">Ответственный:</div>
                        <div class="span8">
                            <input type="text" data-bind="value: worker">
                            <span class="bottom" data-bind="text: errors.worker_error()"></span>
                        </div>
                    </div>
                    <div class="row-form" data-bind="css: {'error': errors.customer_error().length}">
                        <div class="span4">Заказчик:</div>
                        <div class="span8">
                            <input type="text" data-bind="value: customer">
                            <span class="bottom" data-bind="text: errors.customer_error()"></span>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Телефон заказчика:</div>
                        <div class="span8">
                            <input type="text" data-mask="phone" data-bind="value: customer_phone">
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Комментарий:</div>
                        <div class="span8">
                            <textarea data-bind="value: comment"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <h3>Монтаж</h3>

            <div id="order_install">
                <div class="block-fluid">
                    <div class="row-form">
                        <div class="span4">Монтаж:</div>
                        <div class="span8">
                            <input type="checkbox" checked="checked" data-bind="checked: need_install">
                        </div>
                    </div>

                    <div class="row-form" data-bind="visible: need_install">
                        <div class="span4">ФИО ответственного:</div>
                        <div class="span8">
                            <input type="text" data-bind="value: install_person">
                        </div>
                    </div>

                    <div class="row-form" data-bind="visible: need_install">
                        <div class="span4">Телефон:</div>
                        <div class="span8">
                            <input type="text" data-mask="phone" data-bind="value: install_phone">
                        </div>
                    </div>

                    <div class="row-form" data-bind="visible: need_install">
                        <div class="span4">Адрес:</div>
                        <div class="span8">
                            <input type="text" data-bind="value: install_address">
                        </div>
                    </div>

                    <div class="row-form" data-bind="visible: need_install">
                        <div class="span4">Комментарий к монтажу:</div>
                        <div class="span8">
                            <textarea data-bind="value: install_comment"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <h3>Продукты</h3>

            <div id="order_products">
                <div class="table-wr">
                    <table class="products-table-list">
                        <thead>
                        <tr>
                            <th class="cell-num">№</th>
                            <th class="cell-articul">Артикул</th>
                            <th class="cell-name">Наименование</th>
                            <th class="cell-count">Кол-во</th>
                            <th class="cell-comment">Комментарий</th>
                            <th class="cell-price">Цена</th>
                            <th class="cell-amount">Сумма</th>
                            <th class="cell-actions"></th>
                        </tr>
                        </thead>
                        <tbody data-bind="foreach: products">

                        <tr>
                            <td class="cell-num" data-bind="text: $index() + 1"></td>
                            <td class="cell-articul">
                                <select
                                    data-bind="options: $root.articuls_book, value: product_id, optionsValue: 'id', optionsText: 'label', select2:{}"
                                    style="width: 150px"></select>
                            </td>
                            <td class="cell-name">
                                <select
                                    data-bind="options: $root.names_book, value: product_id, optionsValue: 'id', optionsText: 'label', select2:{}"
                                    style="width: 150px"></select>
                            </td>
                            <td class="cell-count">
                                <input type="text" maxlength="3" data-bind="value: count" autocomplete="off">
                            </td>
                            <td class="cell-comment">
                                <input type="text" data-bind="value: comment"/>
                            </td>
                            <td class="cell-price">
                                <span data-bind="text: App.Helper.formatMoney(price())"></span>
                            </td>
                            <td class="cell-amount">
                                <span data-bind="text: App.Helper.formatMoney(total())"></span>
                            </td>
                            <td class="cell-actions">
                                <button class="btn btn-mini" data-bind="click: $root.delete_production_click"><span
                                        class="icon-remove"></span></button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="order-footer">
                        <span class="total-amount">Сумма заказа: <b
                                data-bind="text: App.Helper.formatMoney($root.total_amount()) + ' руб.'"></b></span>
                    <button class="btn btn-mini btn-success btn-add-production"
                            data-bind="click: add_production_click">
                        Добавить продукцию
                    </button>
                </div>
            </div>
        </div>


    </div>
    <div class="modal-footer">
        <img src="/img/loaders/1d_2.gif" data-bind="visible: loading">
        <button class="btn btn-primary"
                data-bind="visible: !loading(), click: submit_order, text: id() ? 'Сохранить' : 'Добавить заказ'"></button>
        <button id="closeForm" class="btn btn-warning" data-bind="visible: !loading()" data-dismiss="modal"
                aria-hidden="true">
            Закрыть
        </button>
    </div>
</div>

<script>
    $('.accordion').accordion({heightStyle: "content"});
</script>