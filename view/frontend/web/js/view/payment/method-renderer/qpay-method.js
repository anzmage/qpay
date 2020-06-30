define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Nology_Qpay/payment/qpay'
            },
            getMailingAddress: function () {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },
            getInstructions: function () {
				//var instructions = window.checkoutConfig.payment.instructions[this.item.method];
				return '';
            },
        });
    }
);
