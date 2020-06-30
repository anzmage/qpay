<?php
namespace Nology\Qpay\Controller\Qpay;

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
		
		echo 'test euy asdasdasd2423423432';
		//return $this->_pageFactory->create();
	}
}