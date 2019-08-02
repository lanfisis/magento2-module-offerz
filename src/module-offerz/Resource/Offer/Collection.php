<?php

namespace Burdz\Offerz\Resource\Offer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Burdz\Offerz\Model\Offer as OfferModel;
use Burdz\Offerz\Resource\Offer as OfferResource;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class Collection extends AbstractCollection
{
    /**
    * @return void
    */
    protected function _construct()
    {
        $this->_init(OfferModel::class, OfferResource::class);
    }
}
