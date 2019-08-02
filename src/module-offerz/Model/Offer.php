<?php

namespace Burdz\Offerz\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Burdz\Offerz\Api\Data\OfferInterface;
use Burdz\Offerz\Resource\Offer as OfferResource;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class Offer extends AbstractModel implements OfferInterface, IdentityInterface
{
    /**
     * @return int
     */
    public function getOfferId(): int
    {
        return parent::getData(self::FIELD_OFFER_ID);
    }

    /**
     * @param int $offerId
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setOfferId(int $offerId): OfferInterface
    {
        return parent::setData(self::FIELD_OFFER_ID, $offerId);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return parent::getData(self::FIELD_LABEL);
    }

    /**
     * @param string $label
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setLabel(string $label): OfferInterface
    {
        return parent::setData(self::FIELD_LABEL, $label);
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return parent::getData(self::FIELD_IMAGE);
    }

    /**
     * @param string $image
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setImage(string $image): OfferInterface
    {
        return parent::setData(self::FIELD_IMAGE, $image);
    }

    /**
     * @return string
     */
    public function getImageInfo(): string
    {
        return parent::getData(self::FIELD_IMAGE_INFO);
    }

    /**
     * @param string $imageInfo
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setImageInfo(string $imageInfo): OfferInterface
    {
        return parent::setData(self::FIELD_IMAGE_INFO, $imageInfo);
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return parent::getData(self::FIELD_LINK);
    }

    /**
     * @param string $link
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setLink(string $link): OfferInterface
    {
        return parent::setData(self::FIELD_LINK, $link);
    }

    /**
     * @return string|null
     */
    public function getFromDate(): ?string
    {
        return parent::getData(self::FIELD_FROM_DATE);
    }

    /**
     * @param string|null $fromDate
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setFromDate(?string $fromDate): OfferInterface
    {
        return parent::setData(self::FIELD_FROM_DATE, $fromDate);
    }

    /**
     * @return string|null
     */
    public function getToDate(): ?string
    {
        return parent::getData(self::FIELD_TO_DATE);
    }

    /**
     * @param string|null $toDate
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setToDate(?string $toDate): OfferInterface
    {
        return parent::setData(self::FIELD_TO_DATE, $toDate);
    }

    /**
     * @return string
     */
    public function getCreationTime(): string
    {
        return parent::getData(self::FIELD_CREATION_TIME);
    }

    /**
     * @return string
     */
    public function getUpdateTime(): string
    {
        return parent::getData(self::FIELD_UPDATE_TIME);
    }

    /**
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(OfferResource::class);
    }
}
