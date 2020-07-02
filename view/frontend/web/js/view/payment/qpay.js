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
            },
			{
                type: 'mpgs',
                component: 'Nology_Qpay/js/view/payment/method-renderer/mpgs-method'
            }
        );
        return Component.extend({});
    }
);