App.DataPointGate = function () {

    var prepareParams = function (_params) {

        for (var i in _params) {
            var param = _params[i];

            if (param instanceof Date) {
                param = param.getFullYear() + '-' + App.Helper.to2(param.getMonth()) + '-' + App.Helper.to2(param.getDate());
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

    AddOrder: function (_order, _callback, _errorCallback) {
        this._dataPointGate.Request('orders', 'Create', _order, _callback, _errorCallback);
    }

};