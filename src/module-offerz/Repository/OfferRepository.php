<?php

namespace Burdz\Offerz\Repository;

use Burdz\Offerz\Api\Data\OfferInterface;
use Burdz\Offerz\Api\OfferRepositoryInterface;
use Burdz\Offerz\Api\OfferSearchResultInterface;
use Burdz\Offerz\Resource\Offer as OfferResource;
use Burdz\Offerz\Api\Data\OfferInterfaceFactory;
use Burdz\Offerz\Api\OfferSearchResultInterfaceFactory;
use Burdz\Offerz\Resource\Offer\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Catalog\Model\Category;
use Magento\Framework\App\CacheInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class OfferRepository implements OfferRepositoryInterface
{
    /**
     * @var \Burdz\Offerz\Resource\Offer
     */
    protected $offerResource;

    /**
     * @var \Burdz\Offerz\Api\Data\OfferInterfaceFactory
     */
    protected $offerFactory;

    /**
     * @var \Burdz\Offerz\Api\OfferSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Burdz\Offerz\Resource\Offer\CollectionFactory
     */
    protected $offerCollectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $cacheManager;

    /**
     * @param \Burdz\Offerz\Resource\Offer $offerResource
     * @param \Burdz\Offerz\Api\Data\OfferInterfaceFactory $offerFactory
     * @param \Burdz\Offerz\Api\OfferSearchResultInterfaceFactory $searchResultsFactory
     * @param \Burdz\Offerz\Resource\Offer\CollectionFactory $offerCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Magento\Framework\App\CacheInterface $cacheManager
     */
    public function __construct(
        OfferResource $offerResource,
        OfferInterfaceFactory $offerFactory,
        OfferSearchResultInterfaceFactory $searchResultsFactory,
        CollectionFactory $offerCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        CacheInterface $cacheManager
    ) {
        $this->offerResource = $offerResource;
        $this->offerFactory = $offerFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->offerCollectionFactory = $offerCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @param int $id
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $id): OfferInterface
    {
        $offer = $this->offerFactory->create();
        $this->offerResource->load($offer, $id);
        if (!$offer->getId()) {
            throw new NoSuchEntityException(__('Offer with id "%1" does not exist.', $id));
        }
        return $offer;
    }

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface $offer
     * @return array
     */
    public function getAssociateCategories(OfferInterface $offer): array
    {
        $linkTable = $this->offerResource->getConnection()->getTableName(OfferInterface::TABLE_LINK_NAME);
        $sql = $this->offerResource->getConnection()->select()->from(['m' => $linkTable], ['category_id'])->where('offer_id <= ?', $offer->getId());
        return $this->offerResource->getConnection()->fetchCol($sql);
    }

    /**
     * @param int $id
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByCategoryId(int $id): OfferInterface
    {
        // TODO: Implement getByCategoryId() method.
    }

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface $offer
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(OfferInterface $offer): OfferInterface
    {
        try {
            $this->offerResource->save($offer);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the offer: %1',
                $exception->getMessage()
            ));
        }
        return $offer;
    }

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface $offer
     * @param array $categoryIds
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function saveAssociateCategories(OfferInterface $offer, array $categoryIds): OfferInterface
    {
        if ($offer->getId() === null) {
            $offer = $this->save($offer);
        }
        $linkTable = $this->offerResource->getConnection()->getTableName(OfferInterface::TABLE_LINK_NAME);
        $this->offerResource->getConnection()->delete($linkTable, ['offer_id <= ?' => $offer->getId()]);
        $insert = $tags = [];
        foreach ($categoryIds as $id) {
            $tags[] = Category::CACHE_TAG . '_' . $id;
            $insert[] = [
                'offer_id' => $offer->getId(),
                'category_id' => $id,
            ];
        }
        $this->cacheManager->clean($tags);
        $this->offerResource->getConnection()->insertMultiple($linkTable, $insert);
        return $offer;
    }

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface $offer
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(OfferInterface $offer): bool
    {
        try {
            $this->offerResource->delete($offer);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->get($id));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Burdz\Offerz\Api\OfferSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria): OfferSearchResultInterface
    {
        $collection = $this->offerCollectionFactory->create();
        $collection->hasCategoryLink(true);
        $this->collectionProcessor->process($criteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
