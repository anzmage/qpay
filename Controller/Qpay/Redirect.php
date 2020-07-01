<?php
namespace Nology\Qpay\Controller\Qpay;

class Redirect extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $storeConfig;
	protected $timezone;
	protected $checkoutSession;
	protected $urlInterface;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Framework\UrlInterface $urlInterface
		)
	{
		$this->_pageFactory = $pageFactory;
		$this->storeConfig = $scopeConfig;
		$this->timezone = $timezone;
		$this->checkoutSession = $checkoutSession;
		$this->urlInterface = $urlInterface;
		return parent::__construct($context);
	}

	public function execute()
	{
		$orderData = $this->checkoutSession->getLastRealOrder();
		echo '<pre>';
		$formatedRequestDate = $this->timezone->date()->format('dmYHis');
		
		$PAYONE_SECRET_KEY = $this->getConfigValue('secret_key');  
		echo 'PAYONE_SECRET_KEY:'.$PAYONE_SECRET_KEY.chr(10);
		$formatedRequestDate = date('dmYHis'); //'02042016224357'
		$parameters = array();
		$parameters['Action'] = '14';
		$parameters['BankID'] = $this->getConfigValue('bank_id'); //Use your Bank(Acquirer) ID
		$parameters['MerchantID'] = $this->getConfigValue('merchant_id'); //Use your Merchant ID
		$parameters['CurrencyCode'] = $this->getConfigValue('merchant_id'); //840 for USD
		$parameters['Amount'] = $orderData->getGrandTotal();
		$parameters['PUN'] =  $this->checkoutSession->getLastRealOrderId();
		$parameters['PaymentDescription'] = urlencode("Payment Description");
		$parameters['MerchantModuleSessionID'] = md5($this->checkoutSession->getLastRealOrderId()); 
		$parameters['TransactionRequestDate'] = $formatedRequestDate;
		$parameters['Quantity'] = round($orderData->getTotalQtyOrdered(),0);
		$parameters['Lang'] = $this->getConfigValue('lang_code');
		$parameters['NationalID'] = $this->getConfigValue('national_id');
		$parameters['ExtraFields_f14'] = $this->urlInterface->getUrl('nology/qpay/respond');//merchant response url
		$parameters['ExtraFields_f3'] = "ThemeID";
		ksort($parameters);
		$orderedString = $PAYONE_SECRET_KEY;
		foreach($parameters as $k=>$param){
		echo $param.chr(10);
		$orderedString .= $param;
		}
		echo "--- Ordered String ---".chr(10);
		echo $orderedString.chr(10);
		$secureHash = hash('sha256', $orderedString, false);
		echo "--- Hash Value ---".chr(10);
		echo $secureHash.chr(10).chr(10).chr(10).chr(10);
		
		$parameters['SecureHash'] = $secureHash;
		
		/*
		$attributesData = array();
		$attributesData['Action'] = "0";
		$attributesData['TransactionRequestDate'] = $formatedRequestDate;
		$attributesData['Amount'] = "100";
		$attributesData['NationalID'] = "UAE";
		$attributesData['PUN'] = "432123129129129129";
		$attributesData['MerchantModuleSessionID'] = "QFqn-hrzwLymc2qHjWEys2Y";
		$attributesData['MerchantID'] = "ANBRedirectM";
		$attributesData['BankID'] = "BankID";
		$attributesData['Lang'] = "AR";
		$attributesData['CurrencyCode'] = "840";
		$attributesData['ExtraFields_f3'] = "ThemeID";
		$attributesData['ExtraFields_f14'] = "http://merchantsiteURL";
		$attributesData['Quantity'] = "2"; */
		
		print_r($parameters);
		
		echo __('<center>Please wait, being redirected to payment gateway.......</center>');
		
		echo "<form action='".$this->getConfigValue('pay_redirect_url')."' method='POST' name='redirectForm'>";
		foreach($parameters as $pkey=>$pval)
		echo "<input type='hidden' name='$pkey' value='$pval' /> ";
		echo '</form>';
		//echo '<script>document.redirectForm.submit();</script>';
		
		?>
		
		<?php 
		//return $this->_pageFactory->create();
	}
	
	public function getConfigValue($param)
	{
		return $this->storeConfig->getValue('payment/qpay/'.$param, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}
}