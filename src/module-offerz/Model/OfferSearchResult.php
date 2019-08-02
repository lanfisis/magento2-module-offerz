<?php

namespace Burdz\Offerz\Model;

use Magento\Framework\Api\SearchResults;
use Burdz\Offerz\Api\OfferSearchResultInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class OfferSearchResult extends SearchResults implements OfferSearchResultInterface
{
    /**
     * @return \Burdz\Offerz\Api\Data\OfferInterface[]
     */
    public function getItems(): array
    {
        return parent::getItems();
    }

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface[] $items
     * @return \Burdz\Offerz\Api\OfferSearchResultInterface
     */
    public function setItems(array $items): OfferSearchResultInterface
    {
        return parent::setItems($items);
    }
}
