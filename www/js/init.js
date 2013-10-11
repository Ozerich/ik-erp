jQuery.fn.center = function () {
    this.css("position", "absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
        $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
        $(window).scrollLeft()) + "px");
    return this;
};

$.datepicker.regional['ru'] = {
    closeText: 'Закрыть',
    prevText: '&#x3c;Пред',
    nextText: 'След&#x3e;',
    currentText: 'Сегодня',
    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
        'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
    dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
    dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
    dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    weekHeader: 'Не',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['ru']);

$(function () {
    $("input[data-mask=phone]").mask('+7 (999) 999-99-99');
});

var App = {};

App.Helper = {

    SHORT_WEEKDAYS: ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вск'],
    MONTHS: ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],

    // Проверяет, является ли параметр числом
    isNumber: function (o) {
        return !(o instanceof Date) && !isNaN(o - 0) && o !== null && o !== "" && o !== false;
    },

    // Проверяет, является ли параметр строкой
    isString: function (o) {
        return typeof o == 'string' || o instanceof String;
    },

    to2: function (o) {
        return o < 10 ? '0' + o : o;
    },

    strToDate: function (str) {
        return new Date(str.substr(0, 4), parseInt(str.substr(5, 2)) - 1, str.substr(8, 2));
    },

    dateToStr: function (date) {
        if (!date) {
            return '';
        }
        return this.to2(date.getDate()) + '.' + this.to2(date.getMonth() + 1) + '.' + date.getFullYear();
    },
	
	daysBeetween: function (date1, date2) {
		var ONE_DAY = 1000 * 60 * 60 * 24;

		var date1_ms = date1.getTime();
		var date2_ms = date2.getTime();

		var difference_ms = date1_ms - date2_ms;

		return Math.round(difference_ms/ONE_DAY);
	},

    getMonthName: function (date) {
        return this.MONTHS[date.getMonth()];
    },

    getWeekDayName: function (date) {
        return this.SHORT_WEEKDAYS[date.getDay() == 0 ? 6 : date.getDay() - 1];
    },

    formatMoney: function (_val) {
        _val = parseInt(_val);
        if (isNaN(_val)) {
            _val = 0;
        }

        var groupPattern = /(\d)(?=(\d{3})+$)/g;
        _val = _val.toString().replace(groupPattern, '$1 ');
        _val = _val.replace(/,$/, '');
        return _val;
    },

    nl2br: function (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

};
