
define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
], function (ko, Component, urlBuilder,storage) {
    'use strict';


    return Component.extend({

        defaults: {
            template: 'Neosolax_Crud/btn',
        },

        productList: ko.observableArray([]),

        getEditForm: function () {
            var self = this;
            var serviceUrl = urlBuilder.build('');
            return storage.post(
                serviceUrl,
                ''
            ).done(
                function (response) {
                    self.productList.push(JSON.parse(response));
                }
            ).fail(
                function (response) {
                    alert(response);
                }
            );
        },

    });
});
