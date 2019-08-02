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
class Index extends Offer implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Burdz_Offerz::burdz_offerz_offer_list';

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $this->dataPersistor->clear('burdz_offerz_offer');
        $resultPage = $this->initPage($this->resultPageFactory->create(), __('Category Offers List'));
        $resultPage->getConfig()->getTitle()->prepend(__('Category Offers List'));
        return $resultPage;
    }
}
