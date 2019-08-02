<?php

namespace Burdz\Offerz\Controller\Adminhtml\Offer;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Burdz\Offerz\Controller\Adminhtml\Offer;
use Magento\Framework\Controller\ResultInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class Save extends Offer implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Burdz_Offerz::burdz_offerz_offer_add';

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $filtered = $this->postDataProcessor->filter($data);
            $this->dataPersistor->set('burdz_offerz_offer', $data);
            if (!$this->postDataProcessor->validate($filtered)) {
                return $resultRedirect->setPath('*/*/edit', ['_current' => true]);
            }
            try {
                $offer = $this->offerFactory->create();
                $offer->setData($filtered);
                $offer = $this->offerRepository->save($offer);
                $offer = $this->offerRepository->saveAssociateCategories($offer, $filtered['category_ids']);
                $this->messageManager->addSuccessMessage(__('You save a new offer'));
                $this->dataPersistor->clear('burdz_offerz_offer');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['master_id' => $offer->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving your offer'));
            }
            return $resultRedirect->setPath('*/*/edit', ['master_id' => $this->getRequest()->getParam('master_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
