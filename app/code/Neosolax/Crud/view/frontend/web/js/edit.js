define([
        "jquery",
        'ko',
        'uiComponent',
        'Magento_Ui/js/modal/alert',
        "jquery/ui",
        "mage/translate",
        "mage/mage",
    ], function ($, ko, Component, alert, mage) {
        "use strict";

        return Component.extend({
            defaults: {
                // isHidden: true,
                editSaved: false,
                template: 'Neosolax_Crud/edit',
            },
            /** Initialize observable properties */
            initObservable: function () {
                this._super()
                    .observe('editSaved')
                ;
                this.fname = ko.observable('');
                this.lname = ko.observable('');
                this.dob = ko.observable('');
                this.startDate = ko.observable('');
                this.contact = ko.observable('');
                return this;
            },

            submitEdit: function () {
                var data = {
                    'fname': this.fname(),
                    'lname': this.lname(),
                    'dob': this.dob(),
                    'startDate': this.startDate(),
                    'contact': this.contact()
                };
                console.log(data);
                $.ajax({
                    url: this.getEditRecord,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    context: this,
                    beforeSend: this.ajaxBeforeSend,
                    success: function (response) {
                        this.editSaved(true);
                        alert({
                            content: $.mage.__('Thanks for Submitting.')
                        });
                    },
                    complete: this.ajaxComplete
                });
            }
        });
    }
);
