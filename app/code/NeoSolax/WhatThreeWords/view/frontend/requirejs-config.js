var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/model/payment/method-group': {
                'NeoSolax_WhatThreeWords/js/model/payment/method-group-mixin': true
            },
            'Magento_Checkout/js/action/set-billing-address': {
                'NeoSolax_WhatThreeWords/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/set-shipping-information': {
                'NeoSolax_WhatThreeWords/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'NeoSolax_WhatThreeWords/js/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'NeoSolax_WhatThreeWords/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'NeoSolax_WhatThreeWords/js/action/set-billing-address-mixin': true
            }
        }
    }
};
