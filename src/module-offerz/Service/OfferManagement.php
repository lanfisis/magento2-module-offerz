<?php

namespace Burdz\Offerz\Service;

use Burdz\Offerz\Api\OfferManagementInterface;
use \Burdz\Offerz\Api\Data\OfferInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class OfferManagement implements OfferManagementInterface
{
    public function getActiveOfferFromCategory(int $id): ?OfferInterface
    {

    }
}
