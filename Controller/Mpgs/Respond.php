<?php
namespace Nology\Qpay\Controller\Mpgs;

class Respond extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $mpgsHelper;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Nology\Qpay\Helper\MpgsHelper $mpgsHelper
	)
	{
		$this->_pageFactory = $pageFactory;
		$this->mpgsHelper = $mpgsHelper;
		return parent::__construct($context);
	}

	public function execute()
	{
		$rawInput = file_get_contents('php://input');

        if($rawInput)
        {
            $rawData  = @json_decode($rawInput, true);
			if($rawData)
            $this->klog($rawData);
        }
		
		if(isset($_GET))
		{
			$this->klog($_GET);
		}
		
		if(isset($_POST))
		{
			$this->klog($_POST);
		}
		
		if(isset($_GET['resultIndicator']))
		{
			$this->mpgsHelper->convertQuoteToOrder();
			$this->_redirect('checkout/onepage/success');
			return true;
		}
	}
	
	public function klog($msg, $filename = 'nology_payment_mpgs_respond.log')
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