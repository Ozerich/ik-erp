var pageViewModel, orderFormViewModel;

function Order() {
    var that = this;

    this.id = 0;

    this.opened = ko.observable(false);
    this.toggle_open = function () {
        that.opened(!that.opened());
    };

    this.is_selected = ko.observable(false);

    this.date = ko.observable();
    this.setDate = function (_date) {
        that.date(_date);
    };


    this.need_print = ko.observable(false);

    this.status = ko.observable();
    this.date_start = ko.observable();
    this.shipping_date = ko.observable();
    this.fact_shipping_date = ko.observable();
    this.date_status = ko.observable();
    this.worker = ko.observable();
    this.customer = ko.observable();
    this.customer_phone = ko.observable();
    this.comment = ko.observable();

    this.division = ko.observable(1);

    this.need_install = ko.observable(true);
    this.install_person = ko.observable();
    this.install_phone = ko.observable();
    this.install_address = ko.observable();
    this.install_comment = ko.observable();

    this.is_shipped = ko.observable(false);

    this.order = ko.observable(0);
    this.saveOrderNum = function (newOrder) {

        var error = false;
        if (newOrder.length != 9) {
            error = true;
        }
        else {
            var year = parseInt(newOrder.substr(0, 4));
            if (!year || year < 2012 || year > 2020) {
                error = true;
            }
            var month = parseInt(newOrder.substr(4, 2));
            if (!month || month < 1 || month > 12) {
                error = true;
            }

            var order = parseInt(newOrder.substr(6, 3));
            if (!order || order === 0) {
                error = true;
            }
        }

        if (error) {
            return false;
        }

        this.order(order);

        var date = this.date();
        this.date(new Date(year, month - 1, date.getDate()));

        App.DataPoint.ChangeOrderOrder(this.id, order, year + '-' + (month < 10 ? '0' + month : month + '-' + (date.getDate() < 10 ? '0' + date.getDate() : date.getDate())));

        return true;
    };
    this.saveOrder = function (newOrder) {
        if (!this.saveOrderNum(newOrder)) {
            alert("Неверный формат кода");
        }
        else {
            this.toggle_order_str_edit();
        }
    };

    this.order_str = ko.computed(function () {
        if (!this.date()) {
            return '';
        }

        var date = this.date();

        var result = date.getFullYear();
        result += (date.getMonth() < 9 ? '0' : '') + (date.getMonth() + 1);
        result += (this.order() < 10 ? '00' : (this.order() < 100 ? '0' : '')) + this.order();
        return result;

    }, this);

    this.order_str_edit_mode = ko.observable(false);
    this.toggle_order_str_edit = function () {
        this.order_str_edit_mode(!this.order_str_edit_mode());
    };

    this.sort_date = ko.computed(function () {
        return this.date();
        if (this.is_shipped()) {
            return this.date_status();
        }
        else {
            return this.shipping_date();
        }
    }, this);


    this.products = ko.observableArray();
    this.total_amount = ko.computed(function () {
        var result = 0;
        ko.utils.arrayForEach(that.products(), function (item) {
            result += item.price() * item.count();
        });
        return result;
    });


    this.date_str = ko.computed(function () {
        if (!this.date()) {
            return '';
        }
        return this.date().getDate() + ' ' + App.Helper.getMonthName(this.date());
    }, this);


    this.shipping_date_str = ko.computed(function () {
        if (!this.sort_date()) {
            return ''
        }
        return this.sort_date().getDate() + ' ' + App.Helper.getMonthName(this.sort_date());
    }, this);

    this.shipping_date_day_str = ko.computed(function () {
        if (!this.sort_date()) {
            return ''
        }
        return App.Helper.getWeekDayName(this.sort_date());
    }, this);

    this.division_text = ko.computed(function () {
        if (this.division() == 1) {
            return 'Красивый город Спб';
        }
        else if (this.division() == 2) {
            return 'Красивый город Москва';
        }
        else if (this.division() == 3) {
            return 'Петроплан';
        }
        else {
            return '';
        }
    }, this);


    this.price = ko.computed(function () {
        var result = 0;

        ko.utils.arrayForEach(this.products(), function (product) {
            result += product.total();
        });

        return result;
    }, this);


    this.progress_percent = ko.computed(function () {
        var sum = 0, all = 0;

        ko.utils.arrayForEach(this.products(), function (product) {
            var weight = product.count() * product.price();
            all += weight;

            if (product.state_1() && product.state_2() && product.state_3()) {
                sum += weight;
            }
            else {
                if (product.state_1()) {
                    sum += (weight / 3);
                }
                if (product.state_2()) {
                    sum += (weight / 3);
                }
                if (product.state_3()) {
                    sum += (weight / 3);
                }
            }
        });

        var result = all == 0 ? 100 : Math.round(100 * sum / all);
        if (result == 100 && sum != all) {
            result = 99;
        }
        return result;
    }, this);

    this.progress_text = ko.computed(function () {
        var percent = this.progress_percent();
        if (percent == 100) {
            return 'Готов. Отгрузить полностью?';
        }
        else {
            return percent + ' %';
        }
    }, this);


    this.customer_text = ko.computed(function () {
        return this.division_text() + ', ' + this.customer();
    }, this);

    this.customer_tooltip = ko.computed(function () {
        var comment = this.comment();
        return 'Телефон заказчика: ' + this.customer_phone() + '<br>' +
            'Ответственный: ' + this.worker() + '<br>' +
            'Комментарий: <pre>' + comment + '</pre>';
    }, this);

    this.install_text = ko.computed(function () {
        if (this.need_install() == false) {
            return 'Без монтажа';
        }
        else {
            return 'Наш монтаж по адресу: ' + this.install_address();
        }
    }, this);

    this.install_tooltip = ko.computed(function () {
        if (this.need_install() == false) {
            return '';
        }
        else {
            return 'ФИО Ответственного: ' + this.install_person() + '<br>' +
                'Телефон:' + this.install_phone() + '<br>' +
                'Комментарий: ' + App.Helper.nl2br(this.install_comment());
        }

    }, this);

    this.toJSON = function () {
        var productsJSON = [];

        ko.utils.arrayForEach(this.products(), function (product) {
            if (product.product_id() > 0) {
                productsJSON.push(product.toJSON());
            }
        });

        return {
            id: this.id,
            date: this.date(),
            shipping_date: this.shipping_date(),
            worker: this.worker(),
            customer: this.customer(),
            customer_phone: this.customer_phone(),
            division: this.division(),
            comment: this.comment(),
            need_install: this.need_install(),
            install_person: this.install_person(),
            install_phone: this.install_phone(),
            install_address: this.install_address(),
            install_comment: this.install_comment(),
            status: this.status(),
            products: productsJSON
        };

    }

}

function OrderProduct() {
    this.id = null;

    this.product_id = ko.observable(0);
    this.product = ko.computed(function () {
        return pageViewModel.findProductById(this.product_id());
    }, this);

    this.product_id.subscribe(function (newProductId) {

        var product = pageViewModel.findProductById(newProductId);

        this.price(product ? product.price : 0);
    }, this);

    this.count = ko.observable(1);
    this.done = ko.observable(0);
    this.price = ko.observable(0);
    this.total = ko.computed(function () {
        if (this.product() == null) {
            return 0;
        }
        var result = parseInt(this.count()) * parseInt(this.product().price);
        return isNaN(result) ? 0 : result;
    }, this);

    this.comment = ko.observable('');

    this.state_1 = ko.observable(false);
    this.state_2 = ko.observable(false);
    this.state_3 = ko.observable(false);

    this.toJSON = function () {
        return {
            id: this.id,
            product_id: this.product_id(),
            count: this.count(),
            comment: this.comment()
        };
    }
}

function OrderFormViewModel() {
    var that = this;
    var wnd = $('#order_form');

    this.loading = ko.observable(false);

    this.divisions = [
        {
            id: 1,
            name: 'Красивый город Спб'
        },
        {
            id: 2,
            name: 'Красивый город Москва'
        },
        {
            id: 3,
            name: 'Петроплан'
        }
    ];

    this.id = ko.observable(0);

    this.date = ko.observable();
    this.shipping_date = ko.observable();
    this.fact_shipping_date = ko.observable();
    this.date_status = ko.observable();
    this.worker = ko.observable();
    this.division = ko.observable();
    this.customer = ko.observable();
    this.customer_phone = ko.observable();
    this.comment = ko.observable();

    this.need_install = ko.observable(false);
    this.install_person = ko.observable();
    this.install_phone = ko.observable();
    this.install_address = ko.observable();
    this.install_comment = ko.observable();
    this.order = ko.observable();

    this.status = ko.observable();

    this.products = ko.observableArray([]);

    this.total_amount = ko.computed(function () {
        var result = 0;
        ko.utils.arrayForEach(that.products(), function (item) {
            result += item.price() * item.count();
        });
        return result;
    });

    this.products_book = ko.observableArray([]);
    this.articuls_book = ko.computed(function () {
        var result = [];
        result.push({id: 0, label: "Выберите артикул"});
        ko.utils.arrayForEach(this.products_book(), function (item) {
            result.push({id: item.id, label: item.articul});
        });
        return result;
    }, this);
    this.names_book = ko.computed(function () {
        var result = [];
        result.push({id: 0, label: "Выберите продукт"});
        ko.utils.arrayForEach(this.products_book(), function (item) {
            result.push({id: item.id, label: item.name});
        });
        return result;
    }, this);

    this.delete_production_click = function (product) {
        that.products.remove(product);
    };

    this.add_production_click = function () {
        that.products.push(new OrderProduct());
    };

    this.setOrder = function (order) {

        this.products_book(pageViewModel.products_all);
        if (order === null) {
            this.id(null);
            this.date(new Date());
            this.shipping_date('');
            this.fact_shipping_date('');
            this.date_status('');
            this.worker('');
            this.customer('');
            this.division(1);
            this.customer_phone('');
            this.comment('');
            this.need_install(false);
            this.install_address('');
            this.install_comment('');
            this.install_person('');
            this.install_phone('');
            this.status(0);
            this.products([]);
            this.order(0);
        }
        else {
            this.id(order.id);
            this.date(order.date());
            this.shipping_date(order.shipping_date());
            this.fact_shipping_date(order.fact_shipping_date());
            this.date_status(order.date_status());
            this.worker(order.worker());
            this.customer(order.customer());
            this.division(order.division());
            this.customer_phone(order.customer_phone());
            this.comment(order.comment());
            this.need_install(order.need_install());
            this.install_address(order.install_address());
            this.install_comment(order.install_comment());
            this.install_person(order.install_person());
            this.install_phone(order.install_phone());
            this.status(order.status());
            this.order(order.order());

            this.products([]);

            for (var i = 0; i < order.products().length; i++) {
                var product = new OrderProduct();

                product.id = order.products()[i].id;
                product.product_id(order.products()[i].product_id());
                product.count(order.products()[i].count());
                product.comment(order.products()[i].comment());
                product.state_1(order.products()[i].state_1());
                product.state_2(order.products()[i].state_2());
                product.state_3(order.products()[i].state_3());

                this.products.push(product);
            }

        }
    };

    this.open = function () {

        this.loading(false);

        for (var i in this.errors) {
            this.errors[i]('');
        }

        $('input:checkbox').uniform();

        wnd.modal({
            backdrop: 'static'
        });
    };


    this.errors = {
        shipping_date_error: ko.observable(''),
        customer_error: ko.observable(''),
        worker_error: ko.observable('')
    };

    this.validate = function () {

        for (var i in this.errors) {
            this.errors[i]('');
        }

        if (!this.shipping_date()) {
            this.errors.shipping_date_error('Дата отгрузки не выбрана');
        }

        if (this.customer().length === 0) {
            this.errors.customer_error('Заказчик не выбран');
        }

        if (this.worker().length === 0) {
            this.errors.worker_error('Ответственный не выбран');
        }

        var first_tab_inputs = ['shipping_date', 'customer', 'worker'];
        for (var i in first_tab_inputs) {
            var error = this.errors[first_tab_inputs[i] + '_error'];
            if (error()) {
                wnd.find('.nav-tabs a:first').trigger('click');
                return false;
            }
        }

        return true;
    };

    this.submit_order = function () {
        if (this.validate()) {

            var order = new Order;

            order.id = this.id();
            order.setDate(this.date());
            order.shipping_date(this.shipping_date());
            order.fact_shipping_date(this.fact_shipping_date());
            order.worker(this.worker());
            order.division(this.division());
            order.customer(this.customer());
            order.customer_phone(this.customer_phone());
            order.comment(this.comment());

            order.need_install(this.need_install());
            order.install_address(this.install_address());
            order.install_comment(this.install_comment());
            order.install_person(this.install_person());
            order.install_phone(this.install_phone());

            order.status(this.status());

            order.products([]);
            ko.utils.arrayForEach(this.products(), function (product) {
                var order_product = new OrderProduct;

                order_product.id = product.id;

                order_product.product_id(product.product_id());
                order_product.count(product.count());
                order_product.comment(product.comment());

                order_product.state_1(product.state_1());
                order_product.state_2(product.state_2());
                order_product.state_3(product.state_3());

                order.products.push(order_product);
            });

            that.loading(true);

            App.DataPoint.SubmitOrder(order.toJSON(), function (data) {
                var is_new_order = order.id == null;

                order.id = parseInt(data.order_id);
                order.order(data.order_order);

                for (var j = 0; j < data.order_product_ids.length; j++) {
                    order.products()[j].id = data.order_product_ids[j];
                }

                if (is_new_order) {
                    order.date_start(order.shipping_date());
                    order.fact_shipping_date(order.shipping_date());
                    pageViewModel.orders.push(order);
                    order.opened(false);
                }
                else {
                    var _order = ko.utils.arrayFirst(pageViewModel.orders(), function (_order) {
                        return _order.id == order.id;
                    });

                    order.opened(_order.opened());
                    order.date_start(_order.date_start());
                    order.fact_shipping_date(_order.fact_shipping_date());

                    pageViewModel.orders.replace(_order, order);
                }

                wnd.modal('hide').on('hidden', function () {

                    that.loading(false);
                });

            });

        }
    }
}

function PageViewModel() {
    var that = this;

    var today = new Date();
    this.page_date = ko.observable(null);
    this.page_month = ko.observable(new Date(today.getFullYear(), today.getMonth(), 1));

    this.hasSidebar = ko.observable(true);

    this.active_page_tab = ko.observable(1);
    this.change_tab = function (tab) {

        if (tab == 2) {
            that.hasSidebar(false);
        }
        else {
            that.hasSidebar(true);
        }

        this.active_page_tab(tab);
    };


    this.print_mode = ko.observable(0);

    this.doPrint = function () {
        this.select_order(null);

        if (this.print_mode() == 1) {
            var exceptions = [];
            for (var i = 0; i < this.orders().length; i++) {
                if (this.orders()[i].need_print() == false) {
                    exceptions.push(this.orders()[i].id);
                }
            }

            var $container = $('.orders-container');
            for (var i = 0; i < exceptions.length; i++) {
                $container.find('article[data-id=' + exceptions[i] + ']').hide();
            }


            window.print();

            for (var i = 0; i < exceptions.length; i++) {
                $container.find('article[data-id=' + exceptions[i] + ']').show();
            }
        }
        else {
            window.print();
        }
    };

    this.date_costs = ko.observableArray();

    this.saveDateCost = function (date, cost) {
        if (App.Helper.isString(date)) {
            App.DataPoint.UpdateDateCost(date, cost);

            date = new Date(parseInt(date.substr(0, 4)), parseInt(date.substr(5, 2)) - 1, parseInt(date.substr(8, 2)));

            var found = false;
            var costs = this.date_costs();
            for (var i in costs) {
                if (costs[i].date.getFullYear() == date.getFullYear() && costs[i].date.getMonth() == date.getMonth() && costs[i].date.getDate() == date.getDate()) {
                    costs[i].cost = cost;
                    found = true;
                    break;
                }
            }

            if (!found) {
                costs.push({
                        date: date,
                        cost: cost
                    }
                );
            }


            this.date_costs(costs);
        }
    };

    this.getDateCost = function (date) {
        var costs = this.date_costs();
        for (var i in costs) {
            if (costs[i].date.getFullYear() == date.getFullYear() && costs[i].date.getMonth() == date.getMonth() && costs[i].date.getDate() == date.getDate()) {
                return parseInt(costs[i].cost);
            }
        }
        return 0;
    };

    this.search_keyword = ko.observable('');

    this.orders = ko.observableArray();

    this.findOrderById = function (id) {

        for (var i = 0; i < this.orders().length; i++) {
            if (this.orders()[i].id == id) {
                return this.orders()[i];
            }
        }

        return null;
    };

    this.select_order = function (order) {
        ko.utils.arrayForEach(that.orders(), function (order) {
            order.is_selected(false);
        });
        if (order) {
            order.is_selected(true);
        }
    };

    this.toggleOrderOrder = function (orderModel, mode, event) {
        var $btn = $(event.target).prop('disabled', true);
        App.DataPoint.ToggleOrderOrder(orderModel.id, mode, function (response) {

            var other_order = null;
            for (var i = 0; i < that.orders().length; i++) {
                if (that.orders()[i].id == response.other_order_id) {
                    other_order = that.orders()[i];
                }
            }

            if (other_order) {
                other_order.order(orderModel.order());
            }

            orderModel.order(response.new_order);


            $btn.prop('disabled', false);
        });

    };

    this.filtered_date_orders = ko.computed(function () {

        var date_start, date_end;

        if (that.page_date() !== null) {
            date_start = new Date(that.page_date().getFullYear(), that.page_date().getMonth(), that.page_date().getDate());
            date_end = new Date(that.page_date().getFullYear(), that.page_date().getMonth() + 1, 0);
        }
        else {
            date_start = new Date(1970, 1, 1);
            date_end = new Date(2900, 1, 1);
            if (today.getMonth() != that.page_month().getMonth() || today.getFullYear() != that.page_month().getFullYear()) {
                date_start = new Date(that.page_month().getFullYear(), that.page_month().getMonth(), 1);
                date_end = new Date(that.page_month().getFullYear(), that.page_month().getMonth() + 1, 0);
            }
        }

        return ko.utils.arrayFilter(this.orders(),function (order) {
            return order.sort_date() <= date_end && order.sort_date() >= date_start;
        }).sort(function (left, right) {
                return +left.order() < +right.order() ? -1 : 1;
            });

    }, this);

    this.filtered_orders = ko.computed(function () {
        return ko.utils.arrayFilter(that.filtered_date_orders(), function (order) {

            if (order.is_shipped() && (order.sort_date().getMonth() != that.page_month().getMonth() || order.sort_date().getFullYear() != that.page_month().getFullYear())) {
                return false;
            }

            if (that.active_page_tab() == 3) {
                if (order.is_shipped() || order.status() > 0) {
                    return false;
                }
            }
            else {
                if (order.status() == 0) {
                    return false;
                }
            }

            var search_keyword = that.search_keyword();
            if (search_keyword.length > 0) {

                if (order.customer().indexOf(search_keyword) !== -1) {
                    return true;
                }

                if (order.worker().indexOf(search_keyword) !== -1) {
                    return true;
                }

                for (var i = 0; i < order.products().length; i++) {
                    var product = order.products()[i].product();
                    if (product.name.indexOf(search_keyword) !== -1) {
                        return true;
                    }
                }

                return false;
            }

            return true;
        }, this);
    });


    this.calendar_events = ko.computed(function () {
        var result = [];

        ko.utils.arrayForEach(ko.utils.arrayFilter(this.orders(),function (order) {
            return true;
        }).sort(function (a, b) {
                if (a.status() != b.status()) {
                    return a.status() < b.status() ? 1 : -1;
                }
                return a.date_status() < b.date_status() ? 1 : -1;
            }), function (order) {

            var start = order.date_start();
            start = new Date(start.getFullYear(), start.getMonth(), start.getDate());

            var end = order.fact_shipping_date();
            end = new Date(end.getFullYear(), end.getMonth(), end.getDate());

            var color = '#54A1E6';
            if (order.status() == 0) {
                color = '#ADECAD';
            }
            else if (order.is_shipped()) {
                color = '#aaa';
            }

            result.push({
                model: order,
                title: '<a data-id="' + order.id + '" href="#" class="fc-order-order">' + order.order() + '</a>, <a data-id="' + order.id + '" href="#" class="fc-order-num">Заказ № ' + order.id + '</a>, <a href="#" data-id="' + order.id + '" class="fc-order-amount">' + App.Helper.formatMoney(order.total_amount()) + ' р.</a>',
                start: start,
                end: end,
                backgroundColor: color
            });
        });

        return result;
    }, this);


    this.calendar_date = ko.computed(function () {
        return this.page_date();
    }, this);

    this.calculate_dates = function () {

        var calendar_date = $('#full_calendar').fullCalendar('getDate');

        App.DataPoint.CalculateDates(calendar_date.getMonth() + 1, calendar_date.getFullYear(), function () {
            that.load(function () {
                setTimeout(function () {
                    $('#full_calendar').fullCalendar('gotoDate', calendar_date.getFullYear(), calendar_date.getMonth(), 1);
                }, 0);
            });
        });

    };


    this.products_all = [];

    this.findProductById = function (id) {
        var result = null;

        ko.utils.arrayForEach(this.products_all, function (product) {
            if (product.id == id) {
                result = product;
                return false;
            }
        });

        return result;
    };

    this.change_status = function (order, status) {
        if (status === 7)return;
        order.status(status);

        App.DataPoint.ChangeOrderStatus(order.id, status, function (response) {
            order.order(response.order_order);
        });
    };

    this.change_state = function (num, data) {

        if (num == 1) {
            data.state_1(!data.state_1());
            App.DataPoint.ChangeOrderProductState(data.id, 1, data.state_1());
        }

        else if (num == 2) {
            data.state_2(!data.state_2());
            App.DataPoint.ChangeOrderProductState(data.id, 2, data.state_2());
        }

        else if (num == 3) {
            data.state_3(!data.state_3());
            App.DataPoint.ChangeOrderProductState(data.id, 3, data.state_3());
        }

    };

    this.delete_order = function (order) {
        if (!confirm('Вы уверены, что хотите удалить заказ?')) {
            return false;
        }

        App.DataPoint.DeleteOrder(order.id);
        that.orders.remove(order);
    };

    this.init_loading = ko.observable(false);
    this.load = function (callback) {
        this.init_loading(true);

        that.products_all = [];
        that.orders([]);
        that.date_costs([]);

        App.DataPoint.GetAllProducts(function (data) {

            for (var i in data) {
                that.products_all.push(data[i]);
            }

            App.DataPoint.GetAllOrders(function (data) {
                that.init_loading(false);

                for (var i in data.orders) {
                    var order = data.orders[i];

                    var model = new Order();

                    model.id = parseInt(order.id);
                    model.setDate(App.Helper.strToDate(order.date));
                    model.shipping_date(App.Helper.strToDate(order.shipping_date));
                    model.fact_shipping_date(App.Helper.strToDate(order.fact_shipping_date));
                    model.date_status(App.Helper.strToDate(order.date_status));
                    model.date_start(App.Helper.strToDate(order.date_start));
                    model.customer(order.customer);
                    model.status(+order.status);
                    model.customer_phone(order.customer_phone);
                    model.comment(order.comment);
                    model.worker(order.worker);
                    model.need_install(order.need_install != 0);
                    model.install_address(order.install_address);
                    model.install_comment(order.install_comment);
                    model.install_person(order.install_person);
                    model.install_phone(order.install_phone);
                    model.is_shipped(order.is_shipped);
                    model.order(+order.order);

                    model.opened(false);

                    for (var j in order.products) {
                        var order_product = order.products[j];

                        var order_product_model = new OrderProduct();

                        order_product_model.id = parseInt(order_product.id);
                        order_product_model.product_id(order_product.product_id);
                        order_product_model.count(parseInt(order_product.count));
                        order_product_model.done(parseInt(order_product.done));
                        order_product_model.comment(order_product.comment);
                        order_product_model.state_1(order_product.state_1 == 1);
                        order_product_model.state_2(order_product.state_2 == 1);
                        order_product_model.state_3(order_product.state_3 == 1);

                        model.products.push(order_product_model);
                    }

                    that.orders.push(model);
                }

                for (var date in data.day_costs) {
                    that.date_costs.push({
                        date: new Date(parseInt(date.substr(0, 4)), parseInt(date.substr(5, 2)) - 1, parseInt(date.substr(8, 2))),
                        cost: data.day_costs[date]
                    });
                }

                if (callback) {
                    callback();
                }

            });
        });

    };
    this.load();

    this.toggle_all = function () {
        var exist_opened = false;
        ko.utils.arrayForEach(this.orders(), function (order) {
            if (order.opened()) {
                exist_opened = true;
                return false;
            }
        });

        ko.utils.arrayMap(this.orders(), function (order) {
            order.opened(!exist_opened);
        });

    };

    this.new_order_click = function () {

        if (that.init_loading())return false;

        orderFormViewModel.setOrder(null);

        orderFormViewModel.open();
    };

    this.edit_order_click = function (order) {
        orderFormViewModel.setOrder(order);
        orderFormViewModel.open();
    };

    this.updateCalendarSummary = function () {
        var $summary = $('.calendar-summary-container').find('.calendar-summary-rows').empty();
        $('.fc-week').each(function () {
            var days_count = 0, total = 0, average, height = $(this).height();
            $(this).find('.fc-day').each(function () {
                days_count++;
                total += parseInt($(this).find('.price-view').text().replace(' ', ''));
            });
            average = Math.round(total / days_count);
            $summary.append('<div class="row" style="height: ' + height + 'px">' +
                '<span>Сумма ' + App.Helper.formatMoney(total) + ' р.</span>' +
                '<span>Средняя ' + App.Helper.formatMoney(average) + ' р.</span>' +
                '</div>'
            );
        });
    };
}


$(function () {

    orderFormViewModel = new OrderFormViewModel();
    pageViewModel = new PageViewModel();

    ko.applyBindings(pageViewModel, $('#page').get(0));
    ko.applyBindings(orderFormViewModel, $('#order_form').get(0));

    $('#calendar').Calendar(function (date) {
        pageViewModel.page_date(date);
    }, function (month) {
        pageViewModel.page_month(month);
    });

    $('[data-toggle=tooltip]').tooltip();

    $('#full_calendar').on('click', '.price-view',function () {
        var day = $(this).parents('td');
        day.find('.price-edit').show();
        day.find('.price-view').hide();

        day.find('.price-edit input').focus();

        return false;
    }).on('click', '.btn-cancel',function () {
            var day = $(this).parents('td');

            day.find('.price-edit input').val(parseInt(day.find('.price-view').text()));

            day.find('.price-edit').hide();
            day.find('.price-view').show();

            return false;
        }).on('click', '.btn-save', function () {
            var day = $(this).parents('td');

            var value = parseInt(day.find('.price-edit input').val());
            if (isNaN(value)) {
                alert('Введите число');
                return false;
            }

            day.find('.price-view').text(App.Helper.formatMoney(value) + ' р.');
            pageViewModel.saveDateCost(day.data('date'), value);

            pageViewModel.updateCalendarSummary();

            day.find('.price-edit').hide();
            day.find('.price-view').show();

            return false;
        });

    $('.orders-container').on('click', '.btn-comment', function (event) {
        $(this).parent().parent().find('.comment-editable').editable('show');
        event.stopPropagation();
        return false;
    });
});

$(document).ready(function () {
    var orderForm = $('#order_form');

    $(document).on('click', '.dateBtn', function (event) {
        event.stopPropagation();
        return false;
    });

    $(document).on('click', '.replaceIt', function (event) {
        var id = $(this).parent().find('span.getId').text();
        $.ajax({
            url: '/production/ajaxDate',
            method: 'post',
            data: {
                'id': id,
            },
            beforeSend: function () {
            },
            success: function () {
                location.reload()
            }
        });
        event.stopPropagation();
        return false;
    });

    $(document).on('click', '.orderDate', function (event) {
        var form = $('#date_form');
        form.find('input.id').val(($(this).parent().find('.order_id').text()));
        form.find('input.newData').val('12.3.2013');
        form.fadeIn();

        event.stopPropagation();
        return false;
    });

    $(document).on('click', '#saveDateForm', function (event) {
        var id = $(this).parent().parent().find('input.id').val();

        var date = $(this).parent().parent().find('input.newData').val();
        $.ajax({
            url: '/production/ajaxNewDate',
            method: 'post',
            data: {
                'id': id,
                'date': date
            },
            beforeSend: function () {
            },
            success: function () {
                location.reload()
            }
        });
        event.stopPropagation();
        return false;
    });

    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            if ($('.modal:visible').length) {
                $('.modal:visible').find('.close').trigger('click');
            }

            pageViewModel.select_order(null);
            pageViewModel.print_mode(0);
        }
    });

    $(document).on('click', function (e) {
        var $target = $(e.target);
        if ($target.parents('article.order-article').length === 0 && $target.is('article.order-article') == false) {
            pageViewModel.select_order(null);
        }
    });


    $(document).on('click', '.fc-order-order', function () {
        var id = $(this).data('id');

        var order = pageViewModel.findOrderById(id);
        if (!order) {
            return false;
        }

        var $wnd = $('#order_change_order_modal');

        $wnd.find('h3 span').text(id);
        $wnd.find('.order-order').val(order.order_str());
        $wnd.modal({
            backdrop: 'static'
        });

        return false;
    });


    $(document).on('click', '.fc-order-num', function () {
        var id = $(this).data('id');

        var order = pageViewModel.findOrderById(id);
        if (!order) {
            return false;
        }

        pageViewModel.edit_order_click(order);

        return false;
    });

    $(document).on('click', '.fc-order-amount', function () {
        var id = $(this).data('id');

        var $wnd = $('#order_products_modal');
        $wnd.data('modal', null);

        $wnd.find('h3 span').text(id);

        $wnd.modal({
            remote: '/orders/products/id/' + id,
            backdrop: 'static'
        });
    });

    $('#order_change_order_modal').on('click', '.btn-primary', function () {
        var $wnd = $('#order_change_order_modal');
        var newOrder = $wnd.find('.order-order').val();

        var id = $wnd.find('h3 span').text();
        var order = pageViewModel.findOrderById(id);

        if (!order) {
            return false;
        }

        if (!order.saveOrderNum(newOrder)) {
            alert("Неверный формат кода");
        }
        else {
            $wnd.modal('hide');
        }

        return false;
    });
});
