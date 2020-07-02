<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Nology\Qpay\Model\Payment;

class Mpgs extends \Magento\Payment\Model\Method\AbstractMethod
{

    protected $_code = "mpgs";
    protected $_isOffline = true;

    public function isAvailable(
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
        return parent::isAvailable($quote);
    }
}

