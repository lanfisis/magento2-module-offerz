<?php

namespace Burdz\Offerz\Ui\Filter;

use Burdz\Offerz\Api\Data\OfferInterface;
use DateTime;
use Exception;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class OfferPostDataProcessor
{
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function filter(array $data): array
    {
        if (empty($data[OfferInterface::FIELD_OFFER_ID])) {
            unset($data[OfferInterface::FIELD_OFFER_ID]);
        }
        if (!empty($data[OfferInterface::FIELD_IMAGE_INFO]) && isset($data[OfferInterface::FIELD_IMAGE_INFO][0])) {
            $data[OfferInterface::FIELD_IMAGE_INFO] = $data[OfferInterface::FIELD_IMAGE_INFO][0];
        }
        if (!empty($data[OfferInterface::FIELD_IMAGE_INFO]) && isset($data[OfferInterface::FIELD_IMAGE_INFO]['url'])) {
            $url = $data[OfferInterface::FIELD_IMAGE_INFO]['url'];
            $data[OfferInterface::FIELD_IMAGE] = str_replace(DirectoryList::MEDIA, '', strstr($url, DirectoryList::MEDIA));
        }
        if (!empty($data[OfferInterface::FIELD_FROM_DATE])) {
            try {
                $data[OfferInterface::FIELD_FROM_DATE] = DateTime::createFromFormat('m/d/Y', $data[OfferInterface::FIELD_FROM_DATE])->setTime(0, 0, 0);
            } catch (Exception $e) {
                $data[OfferInterface::FIELD_FROM_DATE] = null;
            }
        }
        if (!empty($data[OfferInterface::FIELD_TO_DATE])) {
            try {
                $data[OfferInterface::FIELD_TO_DATE] = DateTime::createFromFormat('m/d/Y', $data[OfferInterface::FIELD_TO_DATE])->setTime(23, 59, 59);
            } catch (Exception $e) {
                $data[OfferInterface::FIELD_TO_DATE] = null;
            }
        }
        return $data;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        $hasError = false;
        if (empty($data[OfferInterface::FIELD_LABEL])) {
            $hasError = true;
            $this->messageManager->addError(__('Field label can not be empty'));
        }
        if (empty($data[OfferInterface::FIELD_IMAGE])) {
            $hasError = true;
            $this->messageManager->addError(__('Field image can not be empty'));
        }
        if (empty($data[OfferInterface::FIELD_LINK])) {
            $hasError = true;
            $this->messageManager->addError(__('Field link can not be empty'));
        }
        if (!filter_var($data[OfferInterface::FIELD_LINK], FILTER_VALIDATE_URL)) {
            $hasError = true;
            $this->messageManager->addError(__('Field link need to be a valid url'));
        }
        if (
            $data[OfferInterface::FIELD_FROM_DATE]
            && $data[OfferInterface::FIELD_TO_DATE]
            && $data[OfferInterface::FIELD_FROM_DATE] > $data[OfferInterface::FIELD_TO_DATE]
        ) {
            $hasError = true;
            $this->messageManager->addError(__('To date must be greater than from date'));
        }
        return !$hasError;
    }
}
