<div id="order_form" class="modal hide fade" role="dialog" aria-hidden="true"
     style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Новый заказ (№ 12)</h3>
    </div>
    <div class="row-fluid">

        <ul class="nav nav-tabs">
            <li class="active"><a href="#order_params">Параметры</a></li>
            <li><a href="#order_install">Монтаж</a></li>
            <li><a href="#order_products">Продукция</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="order_params">

                <div class="block-fluid">
                    <div class="row-form" data-bind="css: {'error': errors.date_error().length}">
                        <div class="span4">Дата:</div>
                        <div class="span8">
                            <input type="text" class="datepicker"
                                   data-bind="datepicker: date, datepickerOptions: { minDate: new Date() }">
                            <span class="bottom" data-bind="text: errors.date_error()"></span>
                        </div>
                    </div>
                    <div class="row-form" data-bind="css: {'error': errors.shipping_date_error().length}">
                        <div class="span4">Планируемая дата отгрузки:</div>
                        <div class="span8">
                            <input type="text" class="datepicker" class="datepicker"
                                   data-bind="datepicker: shipping_date, datepickerOptions: { minDate: new Date() }">
                            <span class="bottom" data-bind="text: errors.shipping_date_error()"></span>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Наименование подразделения:</div>
                        <div class="span8">
                            <select data-bind="options: divisions, value: division, optionsValue: 'id', optionsText: 'name'"></select>
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

            <div class="tab-pane" id="order_install">
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

            <div class="tab-pane" id="order_products">
                <div class="table-wr">
                    <table>
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
                                <input type="text" name="spi" value="1"
                                       data-bind="spinner: count, spinnerOptions: { min: 1, max: 100 }"
                                       autocomplete="off"
                                       role="spinbutton">
                            </td>
                            <td class="cell-comment">
                                <textarea data-bind="value: comment"></textarea>
                            </td>
                            <td class="cell-price">
                                <span data-bind="text: price"></span>
                            </td>
                            <td class="cell-amount">
                                <span data-bind="text: total"></span>
                            </td>
                            <td class="cell-actions">
                                <button class="btn btn-mini" data-bind="click: $root.delete_production_click"><span
                                        class="icon-remove"></span></button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <button class="btn btn-mini btn-success btn-add-production" data-bind="click: add_production_click">
                    Добавить продукцию
                </button>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <img src="/img/loaders/1d_2.gif" data-bind="visible: loading">
        <button class="btn btn-primary" data-bind="visible: !loading(), click: submit_order">Добавить заказ</button>
        <button class="btn btn-warning" data-bind="visible: !loading()" data-dismiss="modal" aria-hidden="true">Закрыть</button>
    </div>
</div>