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
class Delete extends Offer implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Burdz_Offerz::burdz_offerz_offer_add';

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('offer_id');
        if ($id) {
            try {
                $this->offerRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the offer.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/', ['offer_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find an offer to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
