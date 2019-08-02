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
class Edit extends Offer implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Burdz_Offerz::burdz_offerz_offer_add';

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $id = $this->getRequest()->getParam('master_id');
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage, __("Category Offer"))->addBreadcrumb(
            $id ? __('Edit Category Offer') : __('New Category Offer'),
            $id ? __('Edit Category Offer') : __('New  Category Offer')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Category Offer'));
        $resultPage->getConfig()->getTitle()->prepend(__('Category Offer'));
        //$resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Category Offer'));
        //$this->registry->register('current_master', $model);
        return $resultPage;
    }
}
