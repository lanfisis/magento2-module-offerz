<?php

namespace Burdz\Offerz\Api;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
interface OfferManagementInterface
{
    /**
     * @param int $id
     * @return \Burdz\Offerz\Api\OfferSearchResultInterface
     * @throws \Exception
     */
    public function getActiveOffersFromCategory(int $id): OfferSearchResultInterface;
}
