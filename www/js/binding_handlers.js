ko.bindingHandlers.datepicker = {
    init: function (element, valueAccessor, allBindingsAccessor) {
        //initialize datepicker with some optional options
        var options = allBindingsAccessor().datepickerOptions || {};
        $(element).datepicker(options);

        //handle the field changing
        ko.utils.registerEventHandler(element, "change", function () {
            var observable = valueAccessor();
            observable($(element).datepicker("getDate"));
        });

        //handle disposal (if KO removes by the template binding)
        ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
            $(element).datepicker("destroy");
        });

    },
    update: function (element, valueAccessor) {
        var value = ko.utils.unwrapObservable(valueAccessor());

        //handle date data coming via json from Microsoft
        if (String(value).indexOf('/Date(') == 0) {
            value = new Date(parseInt(value.replace(/\/Date\((.*?)\)\//gi, "$1")));
        }

        var current = $(element).datepicker("getDate");

        if (value - current !== 0) {
            $(element).datepicker("setDate", value);
        }
    }
};


ko.bindingHandlers.select2 = {
    init: function (element, valueAccessor, allBindingsAccessor) {
        var obj = valueAccessor(),
            allBindings = allBindingsAccessor(),
            lookupKey = allBindings.lookupKey;
        $(element).select2(obj);
        if (lookupKey) {
            var value = ko.utils.unwrapObservable(allBindings.value);
            $(element).select2('data', ko.utils.arrayFirst(obj.data.results, function (item) {
                return item[lookupKey] === value;
            }));
        }

        ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
            $(element).select2('destroy');
        });
    },
    update: function (element) {
        $(element).trigger('change');
    }
};

ko.bindingHandlers.spinner = {

    init: function (element, valueAccessor, allBindingsAccessor) {
        var obj = valueAccessor(),
            allBindings = allBindingsAccessor(),
            lookupKey = allBindings.lookupKey;

        var options = allBindingsAccessor().spinnerOptions || {};
        $(element).spinner(options);

        ko.utils.registerEventHandler(element, "change", function () {
            var observable = valueAccessor();
            observable($(element).spinner("value"));
        });
        ko.utils.registerEventHandler(element, "spinstop", function () {
            var observable = valueAccessor();
            observable($(element).spinner("value"));
        });

    },

    update: function (element, valueAccessor) {
        var value = ko.utils.unwrapObservable(valueAccessor());
        $(element).spinner("value", value);
    }
};

(function (factory) {
    if (typeof define === "function" && define.amd) {
        // AMD anonymous module
        define(["knockout", "jquery"], factory);
    } else {
        // No module loader (plain <script> tag) - put directly in global namespace
        factory(window.ko, window.jQuery);
    }
})(function (ko, $) {
    ko.bindingHandlers.editable = {
        init: function (element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
            var $element = $(element),
                value = valueAccessor(),
                allBindings = allBindingsAccessor(),
                editableOptions = allBindings.editableOptions || {};

            editableOptions.value = ko.utils.unwrapObservable(value);

            if (!editableOptions.name) {
                $.each(bindingContext.$data, function (k, v) {
                    if (v == value) {
                        editableOptions.name = k;
                        return false;
                    }
                });
            }

            //wrap calls to knockout.validation
            if (!editableOptions.validate && value.isValid) {
                editableOptions.validate = function (testValue) {
                    //have to set to new value, then call validate, then reset to original value
                    //not pretty, but works
                    var initalValue = value();
                    value(testValue);
                    var res = value.isValid() ? null : ko.utils.unwrapObservable(value.error);
                    value(initalValue);
                    return res;
                }
            }

            if ((editableOptions.type === 'select' || editableOptions.type === 'checklist' || editableOptions.type === 'typeahead') && !editableOptions.source && editableOptions.options) {
                if (editableOptions.optionsCaption)
                    editableOptions.prepend = editableOptions.optionsCaption;

                //taken directly from ko.bindingHandlers['options']
                function applyToObject(object, predicate, defaultValue) {
                    var predicateType = typeof predicate;
                    if (predicateType == "function")    // Given a function; run it against the data value
                        return predicate(object);
                    else if (predicateType == "string") // Given a string; treat it as a property name on the data value
                        return object[predicate];
                    else                                // Given no optionsText arg; use the data value itself
                        return defaultValue;
                }

                editableOptions.source = function () {
                    return ko.utils.arrayMap(editableOptions.options(), function (item) {
                        var optionValue = applyToObject(item, editableOptions.optionsValue, item);
                        var optionText = applyToObject(item, editableOptions.optionsText, optionText);

                        return {
                            value: ko.utils.unwrapObservable(optionValue),
                            text: ko.utils.unwrapObservable(optionText)
                        };
                    });
                }
            }

            if (editableOptions.visible && ko.isObservable(editableOptions.visible)) {
                editableOptions.toggle = 'manual';
            }

            //create editable
            var $editable = $element.editable(editableOptions);

            //update observable on save
            if (ko.isObservable(value)) {
                $editable.on('save.ko', function (e, params) {
                    value(params.newValue);
                })
            }
            ;

            if (editableOptions.save) {
                $editable.on('save', editableOptions.save);
            }

            //setup observable to fire only when editable changes, not when options change
            //http://www.knockmeout.net/2012/06/knockoutjs-performance-gotcha-3-all-bindings.html
            ko.computed({
                read: function () {
                    var val = ko.utils.unwrapObservable(valueAccessor());
                    if (val === null) val = '';
                    $editable.editable('setValue', val, true)
                },
                owner: this,
                disposeWhenNodeIsRemoved: element
            });

            if (editableOptions.visible && ko.isObservable(editableOptions.visible)) {
                ko.computed({
                    read: function () {
                        var val = ko.utils.unwrapObservable(editableOptions.visible());
                        if (val)
                            $editable.editable('show');
                    },
                    owner: this,
                    disposeWhenNodeIsRemoved: element
                });

                $editable.on('hidden.ko', function (e, params) {
                    editableOptions.visible(false);
                });
            }
        }
    };
});

ko.bindingHandlers.bootstrapPopover = {
    init: function (element, valueAccessor) {
        var options = ko.utils.unwrapObservable(valueAccessor());
        var defaultOptions = {
            placement: 'left'
        };
        options = $.extend(true, {}, defaultOptions, options);

        $(element).on('show', function () {
            $('[rel=popover]').not(element).popover('hide');
        });

        $(element).popover(options);
        $(element).attr('rel', 'popover');
    }
};

ko.bindingHandlers.fullCalendar = {

    update: function (element, valueAccessor) {
        var events = ko.utils.unwrapObservable(valueAccessor());

        setTimeout(function () {
            $(element).empty().fullCalendar('destroy');
            $(element).fullCalendar({
                events: events,
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                firstDay: 1,
                contentHeight: 570,
                dayNamesShort: ['Вск', 'Пн', 'Вт', 'Ср', 'Чтв', 'Пт', 'Сб'],
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль',
                    'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                timeFormat: '',
                dayRender: function (date, cell) {
                    $(cell).find('> div').prepend('<div class="price-block"><div class="price-edit"><input type="text" value="'+pageViewModel.getDateCost(date)+'"><a href="#" class="btn btn-mini btn-save"><i class="icon-ok"></i></a><a href="#" class="btn btn-mini btn-cancel"><i class="icon-remove"></i></a></div><div class="price-view">'+pageViewModel.getDateCost(date) +'р.</div></div>');
                },
                eventAfterRender: function (event, element, view) {
                    $(element).css('top', parseInt($(element).css('top')) + 20 + 'px');
                }
            });
        }, 0);
    }
};

