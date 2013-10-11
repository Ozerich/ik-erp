App.DataPointGate = function () {

    var prepareParams = function (_params) {

        for (var i in _params) {
            var param = _params[i];

            if (param instanceof Date) {
                param = param.getFullYear() + '-' + App.Helper.to2(param.getMonth() + 1) + '-' + App.Helper.to2(param.getDate());
            }

            if (typeof param === 'boolean') {
                param = param ? 1 : 0;
            }

            if (Object.prototype.toString.call(param) === '[object Array]') {
                param = prepareParams(param);
            }

            _params[i] = param;
        }

        return _params;
    };

    // Главная функция, осуществляет запрос к API, выполняя заппрос _command, параметры запроса _params
    this.Request = function (_controller, _action, _params, _callback, _errorCallback) {

        if (_controller.toString().length === 0) {
            throw "Контроллер не может быть пустая";
        }

        if (_action.toString().length === 0) {
            throw "Команда не может быть пустая";
        }

        if (_params === undefined) {
            _params = {};
        }

        _params = prepareParams(_params);

        if (_callback === undefined) {
            _callback = function () {
            };
        }

        if (_errorCallback === undefined) {
            _errorCallback = function () {
            };
        }

        // Проверка на JSON формат
        if (App.Helper.isString(_params)) {
            _params = $.parseJSON(_params);

            if (_params === null) {
                throw "Параметры должны быть в формате JSON";
            }
        }

        // Ajax GET запрос к API
        $.ajax({
            url: '/' + _controller + '/' + _action,
            type: 'POST',
            dataType: 'json',
            data: _params,
            success: _callback,
            error: _errorCallback
        });
    }
};


// Datapoint, вспомогательный класс для загрузки данных
App.DataPoint = {

    // создается объект загручика
    _dataPointGate: new App.DataPointGate(),

    // Получить все продукты
    GetAllProducts: function (_callback, _errorCallback) {
        this._dataPointGate.Request("products", "Get", {}, _callback, _errorCallback);
    },

    GetAllOrders: function (_callback, _errorCallback) {
        this._dataPointGate.Request('orders', 'Get', {}, _callback, _errorCallback);
    },

    SubmitOrder: function (_order, _callback, _errorCallback) {
        this._dataPointGate.Request('orders', 'Submit', _order, _callback, _errorCallback);
    },

    ChangeOrderProductState: function (_order_product_id, _state, _value, _callback, _errorCallback) {
        this._dataPointGate.Request('orders', 'ChangeState', {order_product_id: _order_product_id, state: _state, value: _value}, _callback, _errorCallback);
    },

    ChangeOrderStatus: function (_order_id, _status, _callback, _errorCallback) {
        this._dataPointGate.Request('orders', 'ChangeStatus', {order_id: _order_id, status: _status}, _callback, _errorCallback);
    },

    UpdateDateCost: function (_date_str, _cost, _callback, _errorCallback) {
        this._dataPointGate.Request('orders', 'UpdateDateCost', {date: _date_str, cost: _cost}, _callback, _errorCallback);
    },

    CalculateDates: function (_month, _year, _callback, _errorCallback) {
        this._dataPointGate.Request('orders', 'CalculateDates', {month: _month, year: _year}, _callback, _errorCallback);
    },
	
	UpdateShippingDate: function(_order_id, _date, _callback, _errorCallback){
		this._dataPointGate.Request('orders', 'UpdateShippingDate', {order_id: _order_id, date: _date}, _callback, _errorCallback);
	}


};
