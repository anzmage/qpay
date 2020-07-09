/*browser:true*/
/*global define*/
define(
    [
        'ko',
        'jquery',
        'Magento_Checkout/js/view/payment/default',
		'Nology_Qpay/js/action/set-payment-method-action',
		'https://dohabank.gateway.mastercard.com/checkout/version/56/checkout.js'
    ],
    function (ko, $, Component, setPaymentMethodAction, dohabank) {
        'use strict';
        return Component.extend({
            defaults: {
				//redirectAfterPlaceOrder: false,
                template: 'Nology_Qpay/payment/mpgs'
            },
            getMailingAddress: function () {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },
			popupPayment: function(){
				$('body').trigger('processStart');
				Checkout.configure({
					merchant   : window.checkoutConfig.mpgs_mid,
					order      : {
						amount     : function () { 
							return window.checkoutConfig.quoteData.grand_total;
						},
						currency   : 'QAR',
						description: 'Ordered goods'/*,
						id: '0000002'*/
					},
					billing    : {
						address: {
							street       : '',
							city         : '',
							postcodeZip  : '',
							stateProvince: '',
							country      : 'QAT'
						}
					},
					interaction: {
						operation: 'PURCHASE',
						merchant      : {
							name   : window.checkoutConfig.mpgs_merchant_name
						},
						locale        : 'en_US',
						theme         : 'default',
						displayControl: {
							billingAddress  : 'OPTIONAL',
							customerEmail   : 'HIDE',
							orderSummary    : 'SHOW',
							shipping        : 'HIDE'
						}
					}
				});
				
				Checkout.showLightbox();
				
				return false;
				
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
