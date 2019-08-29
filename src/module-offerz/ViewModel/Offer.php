<?php

namespace Burdz\Offerz\ViewModel;

use Burdz\Offerz\Api\Data\OfferInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Registry;
use Burdz\Offerz\Api\OfferManagementInterface;
use Burdz\Offerz\Api\OfferSearchResultInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class Offer implements ArgumentInterface
{
    /**
     * @param \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Burdz\Offerz\Api\OfferManagementInterface
     */
    protected $offerManagement;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param \Magento\Framework\Registry $registry
     * @param \Burdz\Offerz\Api\OfferManagementInterface $offerManagement
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        Registry $registry,
        OfferManagementInterface $offerManagement,
        StoreManagerInterface $storeManager
    )
    {
        $this->registry = $registry;
        $this->offerManagement = $offerManagement;
        $this->storeManager = $storeManager;
    }

    /**
     * @return OfferInterface|null
     */
    public function getCurrentOffers(): OfferSearchResultInterface
    {
        $category = $this->registry->registry('current_category');
        return $this->offerManagement->getActiveOffersFromCategory($category->getId());
    }

    /**
     * @param string $file
     * @return string
     */
    public function getImageUrl(string $file): string
    {
        $currentStore = $this->storeManager->getStore();
        return $currentStore->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . ltrim($file, '/');
    }
}
