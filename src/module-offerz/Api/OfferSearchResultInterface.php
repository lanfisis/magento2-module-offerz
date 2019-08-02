<?php

namespace Burdz\Offerz\Api;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
interface OfferSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Burdz\Offerz\Api\Data\OfferInterface[]
     */
    public function getItems(): array;

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface[] $items
     * @return \Burdz\Offerz\Api\OfferSearchResultInterface
     */
    public function setItems(array $items): OfferSearchResultInterface;
}
