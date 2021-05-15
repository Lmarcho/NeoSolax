define([
        'jquery',
        'uiComponent',
        'mage/validation',
        'ko',
        'Webkul_Knockout/js/action/save-customer',
    ], function ($, Component, validation, ko, saveAction) {
        'use strict';
        var totalCustomer= ko.observableArray([]);
        return Component.extend({
            defaults: {
                template: 'Neosolax_Webkul/knockout-test2'
            },

            initialize: function () {
                this._super();
            },
            save: function (saveForm) {
                var self = this;
                var saveData = {},
                    formDataArray = $(saveForm).serializeArray();

                formDataArray.forEach(function (entry) {
                    saveData[entry.name] = entry.value;
                });

                if($(saveForm).validation()
                    && $(saveForm).validation('isValid')
                ) {
                    saveAction(saveData, totalCustomer).always(function() {
                        console.log(totalCustomer());
                    });
                }
            },
            getTotalCustomer: function () {
                return totalCustomer;
            }
        });
    }
);
