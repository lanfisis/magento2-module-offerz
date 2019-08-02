<?php

namespace Burdz\Offerz\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Burdz\Offerz\Api\Data\OfferInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
interface OfferRepositoryInterface
{
    /**
     * @param int $id
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $id): OfferInterface;

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface $offer
     * @return array
     */
    public function getAssociateCategories(OfferInterface $offer): array;

    /**
     * @param int $id
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByCategoryId(int $id): OfferInterface;

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface $offer
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(OfferInterface $offer): OfferInterface;

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface $offer
     * @param array $categoryIds
     * @return \Burdz\Offerz\Api\Data\OfferInterface
     */
    public function saveAssociateCategories(OfferInterface $offer, array $categoryIds): OfferInterface;

    /**
     * @param \Burdz\Offerz\Api\Data\OfferInterface $offer
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(OfferInterface $offer): bool;

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Burdz\Offerz\Api\OfferSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria): OfferSearchResultInterface;
}
