<?php

namespace Burdz\Offerz\Ui\DataProvider;

use Burdz\Offerz\Resource\Offer\CollectionFactory;
use Burdz\Offerz\Api\Data\OfferInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Burdz\Offerz\Api\OfferRepositoryInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class OfferDataProvider extends AbstractDataProvider
{
    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Burdz\Offerz\Resource\Offer\Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    protected $serializer;

    /**
     * @var \Burdz\Offerz\Api\OfferRepositoryInterface
     */
    protected $repostitory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Burdz\Offerz\Resource\Offer\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     * @param \Burdz\Offerz\Api\OfferRepositoryInterface $repostitory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        SerializerInterface $serializer,
        OfferRepositoryInterface $repostitory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->serializer = $serializer;
        $this->repostitory = $repostitory;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        foreach ($this->collection->getItems() as $model) {
            $data = $model->getData();
            if (!is_array($data[OfferInterface::FIELD_IMAGE_INFO])) {
                $data[OfferInterface::FIELD_IMAGE_INFO] = [$this->serializer->unserialize($data[OfferInterface::FIELD_IMAGE_INFO])];
            }
            $data['category_ids'] = $this->repostitory->getAssociateCategories($model);
            $this->loadedData[$model->getId()] = $data;
        }
        $data = $this->dataPersistor->get('burdz_offerz_offer');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('burdz_offerz_offer');
        }
        return $this->loadedData;
    }
}
