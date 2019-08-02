<?php

namespace Burdz\Offerz\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Burdz\Offerz\Api\Data\OfferInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class Offer extends AbstractDb
{
    /**
     * @var array
     */
    protected $_serializableFields = [
        OfferInterface::FIELD_IMAGE_INFO => [
            [],
            [],
        ]
    ];

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(OfferInterface::TABLE_NAME, OfferInterface::FIELD_OFFER_ID);
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if (is_a($object->getData(OfferInterface::FIELD_FROM_DATE), '\DateTime')) {
            $object->setData(OfferInterface::FIELD_FROM_DATE, $object->getData(OfferInterface::FIELD_FROM_DATE)->format('Y-m-d H:i:s'));
        }
        if (is_a($object->getData(OfferInterface::FIELD_TO_DATE), '\DateTime')) {
            $object->setData(OfferInterface::FIELD_TO_DATE, $object->getData(OfferInterface::FIELD_TO_DATE)->format('Y-m-d H:i:s'));
        }
        return parent::_beforeSave($object);
    }
}
