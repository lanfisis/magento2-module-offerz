<?php

namespace Burdz\Offerz\Api\Data;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
interface OfferInterface
{
    const ENTITY = 'offer';
    const CACHE_TAG = 'off';

    const TABLE_NAME = 'burdz_offerz_offer';
    const TABLE_LINK_NAME = 'burdz_offerz_offer_category';

    const FIELD_OFFER_ID = 'offer_id';
    const FIELD_LABEL = 'label';
    const FIELD_IMAGE = 'image';
    const FIELD_IMAGE_INFO = 'image_info';
    const FIELD_LINK = 'link';
    const FIELD_FROM_DATE = 'from_date';
    const FIELD_TO_DATE = 'to_date';
    const FIELD_CREATION_TIME = 'creation_time';
    const FIELD_UPDATE_TIME = 'update_time';

    /**
     * @return int
     */
    public function getOfferId(): int;

    /**
     * @param int $offerId
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setOfferId(int $offerId): OfferInterface;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param string $label
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setLabel(string $label): OfferInterface;

    /**
     * @return string
     */
    public function getImage(): string;

    /**
     * @param string $image
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setImage(string $image): OfferInterface;

    /**
     * @return string
     */
    public function getImageInfo(): string;

    /**
     * @param string $imageInfo
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setImageInfo(string $imageInfo): OfferInterface;

    /**
     * @return string
     */
    public function getLink(): string;

    /**
     * @param string $link
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setLink(string $link): OfferInterface;

    /**
     * @return string|null
     */
    public function getFromDate(): ?string;

    /**
     * @param string|null $fromDate
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setFromDate(?string $fromDate): OfferInterface;

    /**
     * @return string|null
     */
    public function getToDate(): ?string;

    /**
     * @param string|null $toDate
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function setToDate(?string $toDate): OfferInterface;

    /**
     * @return string
     */
    public function getCreationTime(): string;

    /**
     * @return string
     */
    public function getUpdateTime(): string;
}
