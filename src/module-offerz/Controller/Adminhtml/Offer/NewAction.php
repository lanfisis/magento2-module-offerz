<?php

namespace Burdz\Offerz\Controller\Adminhtml\Offer;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Burdz\Offerz\Controller\Adminhtml\Offer;
use Magento\Framework\Controller\ResultInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class NewAction extends Offer implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Burdz_Offerz::burdz_offerz_offer_add';

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
