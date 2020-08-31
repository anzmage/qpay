define(
    [
        'ko',
        'jquery',
        'Magento_Checkout/js/view/payment/default',
		'Nology_Qpay/js/action/set-payment-method-action',
		window.checkoutConfig.mpgs_base_url + 'checkout/version/56/checkout.js'
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
				$.get("/nology/mpgs/generate", function(data) {				  
				  Checkout.configure({
					  session: { 
						id: data.session_id
						},
					  interaction: {
							merchant: {
								name: window.checkoutConfig.mpgs_merchant_name,
								address: {
									line1: 'address 1',
									line2: 'address 2'            
								}    
							},
							displayControl: {
								billingAddress  : 'HIDE',
								customerEmail   : 'HIDE',
								orderSummary    : 'SHOW',
								shipping        : 'HIDE'
							}
					   }
					});
				
				Checkout.showLightbox();
				});
								
				return false;
				
			},
            getInstructions: function () {
				return '';
            }
        });
    }
);
