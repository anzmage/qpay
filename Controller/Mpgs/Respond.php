<?php
namespace Nology\Qpay\Controller\Mpgs;

class Respond extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
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

		echo 'test euy asdasdasd2423423432';
		//return $this->_pageFactory->create();
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