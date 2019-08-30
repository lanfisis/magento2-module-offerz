<?php
namespace Burdz\Offerz\Unit\Test\Model;

use Burdz\Offerz\Api\Data\OfferInterface;
use Burdz\Offerz\Model\Offer;
use Burdz\Offerz\Resource\Offer as OfferResource;
use Magento\Cms\Model\Block;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;

/**
 * @covers \Burdz\Offerz\Model\Offer
 */
class OfferTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Burdz\Offerz\Model\Offer
     */
    private $offerModel;

    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    private $objectManager;

    /**
     * @var \Magento\Framework\Event\ManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $eventManagerMock;

    /**
     * @var \Magento\Framework\Model\Context|\PHPUnit_Framework_MockObject_MockObject
     */
    private $contextMock;

    /**
     * @var BlockResource|\PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceMock;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->resourceMock = $this->createMock(OfferResource::class);
        $this->eventManagerMock = $this->createMock(ManagerInterface::class);
        $this->contextMock = $this->createMock(Context::class);
        $this->contextMock->expects($this->any())->method('getEventDispatcher')->willReturn($this->eventManagerMock);
        $this->objectManager = new ObjectManager($this);
        $this->offerModel = $this->objectManager->getObject(
            Offer::class,
            [
                'context' => $this->contextMock,
                'resource' => $this->resourceMock,
            ]
        );
    }

    /**
     * @return void
     */
    public function testGetOfferId()
    {
        $offerId = 12;
        $this->offerModel->setData(OfferInterface::FIELD_OFFER_ID, $offerId);
        $expected = $offerId;
        $actual = $this->offerModel->getOfferId();
        self::assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function testSetOfferId()
    {
        $offerId = 15;
        $this->offerModel->setOfferId($offerId);
        $expected = $offerId;
        $actual = $this->offerModel->getData(OfferInterface::FIELD_OFFER_ID);
        self::assertEquals($expected, $actual);
    }

}
