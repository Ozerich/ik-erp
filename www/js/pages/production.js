function Product() {

    this.id = null;

    this.product_id = null;

    this.articul = ko.observable();
    this.name = ko.observable();

    this.count = ko.observable();

    this.comment = ko.observable();

    this.price = ko.observable();

    this.total_amount = ko.computed(function () {
        return parseInt(this.price()) * parseInt(this.count());
    }, this);
}


var pageViewModel, orderFormViewModel;


function Order() {

    this.id = null;


    this.date = ko.observable();
    this.shipping_date = ko.observable();
    this.worker = ko.observable();
    this.customer = ko.observable();
    this.customer_phone = ko.observable();
    this.comment = ko.observable();

    this.need_install = ko.observable(false);
    this.install_person = ko.observable();
    this.install_phone = ko.observable();
    this.install_address = ko.observable();
    this.install_comment = ko.observable();

    this.products = ko.observableArray([]);
}

function OrderProduct() {
    this.id = null;

    this.product = null;
    this.product_id = ko.observable(0);

    this.product_id.subscribe(function (newProductId) {
        var product_price = 0;

        ko.utils.arrayForEach(orderFormViewModel.products_book(), function (item) {
            if (item.id == newProductId) {
                product_price = item.price;
                return false;
            }
        });

        this.price(product_price);
    }, this);

    this.count = ko.observable(1);
    this.price = ko.observable(0);
    this.total = ko.computed(function () {
        var result = parseInt(this.count()) * parseInt(this.price());
        return isNaN(result) ? 0 : result;
    }, this);

    this.comment = ko.observable('');


}


function OrderFormViewModel() {
    var that = this;
    var wnd = $('#order_form');

    this.date = ko.observable();
    this.shipping_date = ko.observable();
    this.worker = ko.observable();
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
            this.shipping_date(null);
            this.worker('');
            this.customer('');
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

        wnd.find('.nav-tabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        wnd.find('.nav-tabs a:first').trigger('click');


        this.products_book(pageViewModel.products_all);
        wnd.modal();
    };


    this.validate = function () {

        return false;
    };

    this.submit_order = function () {
        if (this.validate()) {
            wnd.modal('hide');
        }
    }
}

function PageViewModel() {
    var that = this;

    this.products_all = [];

    this.init_loading = ko.observable(true);
    this.load = function () {
        App.DataPoint.GetAllProducts(function (data) {

            for (var i in data) {
                that.products_all.push(data[i]);
            }

            App.DataPoint.GetAllOrders(function (data) {
                that.init_loading(false);

            });
        });

    };
    this.load();


    this.new_order_click = function () {

        if(that.init_loading())return false;

        orderFormViewModel.setOrder(null);
        orderFormViewModel.open();

    };
}


$(function () {

    orderFormViewModel = new OrderFormViewModel();
    pageViewModel = new PageViewModel();

    ko.applyBindings(pageViewModel, $('#page').get(0));
    ko.applyBindings(orderFormViewModel, $('#order_form').get(0));

    $('#calendar').Calendar();

    $('input:checkbox').uniform();


});

