<?php
namespace Nology\Qpay\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class MpgsHelper extends AbstractHelper
{

	private $config;	
	protected $checkoutSession;
	protected $storeManager;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\App\Config\ScopeConfigInterface $configStore,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
		$this->config = $configStore;
		$this->checkoutSession = $checkoutSession;
		$this->storeManager = $storeManager;
    }
	
	public function generatePaymentSession()
	{
		$quote = $this->checkoutSession->getQuote();
		$grandTotal = $quote->getGrandTotal();
		$MID = $this->getConfigValue('merchant_id');
		$pass = $this->getConfigValue('merchant_key');
		$baseUrl = $this->getConfigValue('mpgs_url');
		
		$allItems = $quote->getAllVisibleItems();
		$desc = '';
		foreach ($allItems as $item) {
			$desc .= $item->getName() . ' x '. $item->getQty() . "\n";
		}
		
		$respondUrl = $this->storeManager->getStore()->getUrl('nology/mpgs/respond', ['_current' => true, '_use_rewrite' => true]);
		
		$data = [
			"apiOperation"=>"CREATE_CHECKOUT_SESSION",
			"apiUsername"=>"merchant.".$MID,
			"merchant"=>$MID,
			"apiPassword"=>$pass,
			"interaction.operation"=>"VERIFY",
			"order.id"=>($quote->getReserverdOrderId()?:'Q'.$quote->getId()),
			"order.amount"=>$grandTotal,
			"order.currency"=>"QAR",
			"order.description"=>$desc,
			"interaction.returnUrl"=>$respondUrl
		];
		
		//print_r($data);
		$this->klog(['request'=>$data]);
		$url = $baseUrl.'api/nvp/version/56';
		$ch = curl_init($url);
		
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($data));
		$result = curl_exec($ch);
		parse_str($result,$parsed);
		
		return $parsed;
	}
	
	private function getConfigValue($param)
	{
		return $this->config->getValue('payment/mpgs/'.$param);
	}
	
	public function klog($msg, $filename = 'nology_payment_mpgs.log')
    {
        if (is_array($msg)) {
            $msg = print_r($msg, true);
        }
		
		$filename = str_replace('.log','-'.date('Y-m-d').'.log',$filename);

        $writer = new \Zend\Log\Writer\Stream(BP.'/var/log/'.$filename);
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($msg);
    }
}
