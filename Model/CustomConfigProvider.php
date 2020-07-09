<?php
namespace Nology\Qpay\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CustomConfigProvider implements ConfigProviderInterface
{
	private $config;
	
	public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;  
    }
	
	private function getConfigValue($param)
	{
		return $this->config->getValue('payment/mpgs/'.$param);
	}
	
    public function getConfig()
    {
        $config = [];
        $config['mpgs_mid'] = $this->getConfigValue('merchant_id');
		$config['mpgs_merchant_name'] = $this->getConfigValue('store_name');
		

        return $config;
    }
}