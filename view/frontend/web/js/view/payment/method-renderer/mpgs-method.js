/*browser:true*/
/*global define*/
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
				/*
				Checkout.configure({
					merchant   : window.checkoutConfig.mpgs_mid,
					order      : {
						amount     : function () { 
							return window.checkoutConfig.quoteData.grand_total;
						},
						currency   : 'QAR',
						description: 'Ordered goods',
						id: window.checkoutConfig.quoteData.entity_id
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
							billingAddress  : 'HIDE',
							customerEmail   : 'HIDE',
							orderSummary    : 'SHOW',
							shipping        : 'HIDE'
						}
					}
				});*/
				
				$.get( "/nology/mpgs/generate", function( data ) {
				  //var returnedData = JSON.parse(data);
				  console.log(data);
				  //console.log(returnedData);
				  
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
				
				
				//$('body').trigger('processStop');
				
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
