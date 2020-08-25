<?php
namespace Nology\Qpay\Controller\Mpgs;

class Generate extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $jsonFactory;
	protected $mpgsHelper;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
		\Nology\Qpay\Helper\MpgsHelper $mpgsHelper
	)
	{
		$this->_pageFactory = $pageFactory;
		$this->jsonFactory = $jsonFactory;
		$this->mpgsHelper = $mpgsHelper;
		return parent::__construct($context);
	}

	public function execute()
	{ 
		$resultJson = $this->jsonFactory->create();
		$generatedSession = $this->mpgsHelper->generatePaymentSession();
        return $resultJson->setData($generatedSession);
	}
	
	public function klog($msg, $filename = 'nology_payment.log')
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