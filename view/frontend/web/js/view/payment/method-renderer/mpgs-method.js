/*browser:true*/
/*global define*/
define(
    [
        'ko',
        'jquery',
        'Magento_Checkout/js/view/payment/default',
		'Nology_Qpay/js/action/set-payment-method-action'
    ],
    function (ko, $, Component, setPaymentMethodAction) {
        'use strict';
        return Component.extend({
            defaults: {
				//redirectAfterPlaceOrder: false,
                template: 'Nology_Qpay/payment/mpgs'
            },
            getMailingAddress: function () {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },
            getInstructions: function () {
				//var instructions = window.checkoutConfig.payment.instructions[this.item.method];
				return '';
            }/*,
			afterPlaceOrder: function () {
                setPaymentMethodAction(this.messageContainer);
                return false;
            }*/
        });
    }
);
