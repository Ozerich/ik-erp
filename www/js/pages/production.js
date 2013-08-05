var pageViewModel, orderFormViewModel;


function Order() {
    var that = this;

    this.id = 0;

    this.date = ko.observable();
    this.date_str = ko.computed(function () {
        if (!this.date()) {
            return ''
        }
        return this.date().getDate() + ' ' + App.Helper.getMonthName(this.date());
    }, this);
    this.date_day_str = ko.computed(function () {
        if (!this.date()) {
            return ''
        }
        return App.Helper.getWeekDayName(this.date());
    }, this);

    this.setDate = function (_date) {
        that.date(_date);
    };

    this.shipping_date = ko.observable();
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

    this.products = ko.observableArray();

    this.opened = ko.observable(false);
    this.toggle_open = function () {
        that.opened(!that.opened());
    };

    this.price = ko.computed(function () {
        var result = 0;

        ko.utils.arrayForEach(this.products(), function (product) {
            result += product.total();
        });

        return result;
    }, this);


    this.progress_percent = ko.computed(function () {
        return 0;
    });


    this.toJSON = function () {
        var productsJSON = [];

        ko.utils.arrayForEach(this.products(), function (product) {
            productsJSON.push(product.toJSON());
        });

        return {
            date: this.date(),
            shipping_date: this.shipping_date(),
            customer: this.customer(),
            customer_phone: this.customer_phone(),
            division: this.division(),
            comment: this.comment(),
            need_install: this.need_install(),
            install_person: this.install_person(),
            install_phone: this.install_phone(),
            install_address: this.install_address(),
            install_comment: this.install_comment(),
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

    this.date = ko.observable();
    this.shipping_date = ko.observable();
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


    this.products = ko.observableArray([]);

    this.products_book = ko.observableArray([]);
    this.articuls_book = ko.computed(function () {
        var result = [];
        ko.utils.arrayForEach(this.products_book(), function (item) {
            result.push({id: item.id, label: item.articul});
        });
        return result;
    }, this);
    this.names_book = ko.computed(function () {
        var result = [];
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
        if (order === null) {
            this.date(new Date());
            this.shipping_date('');
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
            this.products([new OrderProduct(), new OrderProduct(), new OrderProduct()]);
        }
    };

    this.open = function () {

        this.loading(false);

        wnd.find('.nav-tabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        wnd.find('.nav-tabs a:first').trigger('click');


        this.products_book(pageViewModel.products_all);
        wnd.modal();
    };


    this.errors = {
        date_error: ko.observable(''),
        shipping_date_error: ko.observable(''),
        customer_error: ko.observable(''),
        worker_error: ko.observable('')
    };

    this.validate = function () {

        for (var i in this.errors) {
            this.errors[i]('');
        }

        if (!this.date()) {
            this.errors.date_error('Дата не выбрана');
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

        var first_tab_inputs = ['date', 'shipping_date', 'customer', 'worker'];
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

            order.setDate(this.date());
            order.shipping_date(this.shipping_date());
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

            order.products([]);
            ko.utils.arrayForEach(this.products(), function (product) {
                var order_product = new OrderProduct;

                order_product.id = 0;

                order_product.product_id(product.product_id());
                order_product.count(product.count());
                order_product.comment(product.comment());

                order_product.state_1(false);
                order_product.state_2(false);
                order_product.state_3(false);

                order.products.push(order_product);
            });

            that.loading(true);
            App.DataPoint.AddOrder(order.toJSON(), function (data) {
                that.loading(false);

                order.id = parseInt(data.order_id);
                for (var j = 0; j < data.order_product_ids.length; j++) {
                    order.products()[j].id = data.order_product_ids[j];
                }

                order.opened(false);

                pageViewModel.orders.push(order);

                wnd.modal('hide');
            });

        }
    }
}

function PageViewModel() {
    var that = this;

    this.page_date = ko.observable(new Date());

    this.orders = ko.observableArray();
    this.filtered_orders = ko.computed(function () {

        var date_start = that.page_date();
        var date_end = new Date(that.page_date().getFullYear(), that.page_date().getMonth() + 1, 0);

        return ko.utils.arrayFilter(this.orders(), function (order) {
            return order.date() >= date_start && order.date() <= date_end;
        }).sort(function(left, right){
                return left.date() > right.date() ? 1 : -1;
            });

    }, this);

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

    this.init_loading = ko.observable(true);
    this.load = function () {
        App.DataPoint.GetAllProducts(function (data) {

            for (var i in data) {
                that.products_all.push(data[i]);
            }

            App.DataPoint.GetAllOrders(function (data) {
                that.init_loading(false);

                for (var i in data) {
                    var order = data[i];

                    var model = new Order();

                    model.id = parseInt(order.id);
                    model.setDate(App.Helper.strToDate(order.date));
                    model.shipping_date(App.Helper.strToDate(order.shipping_date));
                    model.customer(order.customer);
                    model.customer_phone(order.customer_phone);
                    model.comment(order.comment);
                    model.worker(order.worker);
                    model.need_install(order.need_install);
                    model.install_address(order.install_address);
                    model.install_comment(order.install_comment);
                    model.install_person(order.install_person);
                    model.install_phone(order.install_phone);
                    model.opened(false);

                    for (var j in order.products) {
                        var order_product = order.products[j];

                        var order_product_model = new OrderProduct();

                        order_product_model.id = order_product.id;
                        order_product_model.product_id(order_product.product_id);
                        order_product_model.count(order_product.count);
                        order_product_model.comment(order_product.comment);
                        order_product_model.state_1(false);
                        order_product_model.state_2(false);
                        order_product_model.state_3(false);

                        model.products.push(order_product_model);
                    }

                    that.orders.push(model);
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
}


$(function () {

    orderFormViewModel = new OrderFormViewModel();
    pageViewModel = new PageViewModel();

    ko.applyBindings(pageViewModel, $('#page').get(0));
    ko.applyBindings(orderFormViewModel, $('#order_form').get(0));

    $('#calendar').Calendar(function (date) {
        pageViewModel.page_date(date);
    });

    $('input:checkbox').uniform();


});

