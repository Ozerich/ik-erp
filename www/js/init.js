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
        return new Date(str.substr(0, 4), str.substr(5, 2), str.substr(8, 2));
    },

    getMonthName: function (date) {
        return this.MONTHS[date.getMonth()];
    },

    getWeekDayName: function (date) {
        return this.SHORT_WEEKDAYS[date.getDay() == 0 ? 6 : date.getDay() - 1];
    }

};
