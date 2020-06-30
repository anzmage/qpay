define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'qpay',
                component: 'Nology_Qpay/js/view/payment/method-renderer/qpay-method'
            }
        );
        return Component.extend({});
    }
);