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
				
				console.log('trigger pop here');
				
				Checkout.configure({
					merchant   : 'DB92668',
					order      : {
						amount     : function () { //Dynamic calculation of amount
							return 80 + 20
						},
						currency   : 'QAR',
						description: 'Ordered goods',
						id: '0000002'
					},
					billing    : {
						address: {
							street       : '123 Customer Street',
							city         : 'Metropolis',
							postcodeZip  : '99999',
							stateProvince: 'QTAR',
							country      : 'QAT'
						}
					},
					interaction: {
						operation: 'PURCHASE',
						merchant      : {
							name   : 'Nama Merchant Euy',
							address: {
										  line1: '200 Sample St',
										  line2: '1234 Example Town'            
							},
							email  : 'order@yourMerchantEmailAddress.com',
							phone  : '+1 123 456 789 012'
						},
						locale        : 'en_US',
						theme         : 'default',
						displayControl: {
							billingAddress  : 'OPTIONAL',
							customerEmail   : 'OPTIONAL',
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
