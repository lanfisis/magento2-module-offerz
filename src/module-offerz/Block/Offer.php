<?php

namespace Burdz\Offerz\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Burdz\Offerz\Api\OfferManagementInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class Offer extends Template
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
     * @param Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Burdz\Offerz\Api\OfferManagementInterface $offerManagement
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        OfferManagementInterface $offerManagement,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->offerManagement = $offerManagement;
        parent::__construct($context, $data);
    }

}
