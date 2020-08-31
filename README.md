This extension integrates a Magento 2 based webstore with the QPAY & MPGS payment service 

## Requirements:
*   An online store with Magento infrastructure. This plugin is tested with Magento v2.3.4
*   PHP v5.6 or greater.
*   MySQL v5.7 or greater.
*   This plugin supports Magento2 version 2.3.4 and higher.

## Installation

 - Unzip the zip file in `app/code/Nology/Qpay`
 - Enable the module by running `php bin/magento module:enable Nology_Qpay`
 - Run this command on magento root folder `php bin/magento setup:upgrade`
 - Next run `php bin/magento setup:di:compile`
 - Next run `php bin/magento setup:static-content:deploy`
 - Flush the cache by running `php bin/magento cache:flush`

## Configuration

Before you begin, make sure that you have successfully installed and enabled this extension.
Configure the extension in your Magento admin panel: 

1. Log in to your Magento admin panel. 
2. In the left navigation bar, go to **Stores(1)** -> **Configuration(2)**. 
3. In the menu, go to **Sales(3)** -> **Payment Methods(4)**

![](https://user-images.githubusercontent.com/21098575/78235369-c133c000-7502-11ea-99af-d28144d5f2ca.png "image_mag_config")

4. There is 2 payment configurations QPAY & MPGS, both payment is pre-configured use test account, fill out all the  fields
5. Save configurations
6. Flush Magento cache at System->Cache Management 

