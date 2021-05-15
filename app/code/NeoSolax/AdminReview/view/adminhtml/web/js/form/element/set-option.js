define([
    'jquery',
    'Magento_Ui/js/form/element/select'
], function ($, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            customName: '${ $.parentName }.${ $.index }_input'
        },
        /**
         * Change currently selected option
         *
         * @param {String} id
         */
        selectOption: function(id){
            if(($("#"+id).val() == 0)||($("#"+id).val() == undefined)) {
                $('div[data-index="video_fieldset"]').hide();
                $('div[data-index="image_fieldset"]').hide();
                // $('div[data-index="video_fieldset"]').hide();
                // $('input[name="small_image"]').hide();


            } else if($("#"+id).val() == 1) {
                $('div[data-index="video_fieldset"]').hide();
                $('div[data-index="image_fieldset"]').show();
                // $('input[name="small_image"]').show();


            }
            else if($("#"+id).val() == 2) {
                $('div[data-index="video_fieldset"]').show();
                $('div[data-index="image_fieldset"]').hide();


            }
        },
    });
});
