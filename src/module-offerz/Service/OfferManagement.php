<?php

namespace Burdz\Offerz\Service;

use Burdz\Offerz\Api\OfferManagementInterface;
use Burdz\Offerz\Api\Data\OfferInterface;
use Burdz\Offerz\Repository\OfferRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Burdz\Offerz\Api\OfferSearchResultInterface;
use Magento\Framework\Api\AbstractSimpleObject;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 * @see https://magento.stackexchange.com/questions/200941/magento2-how-to-add-multiple-and-and-or-conditions-to-filter-filtergroups?rq=1
 */
class OfferManagement implements OfferManagementInterface
{
    /**
     * @var \Burdz\Offerz\Repository\OfferRepository
     */
    protected $offerRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \Magento\Framework\Api\Search\FilterGroupBuilder
     */
    protected $filterGroupBuilder;

    /**
     * @param \Burdz\Offerz\Repository\OfferRepository $offerRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder
     */
    public function __construct(
        OfferRepository $offerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder
    ) {
        $this->offerRepository = $offerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
    }

    /**
     * @param int $id
     * @return \Burdz\Offerz\Api\OfferSearchResultInterface
     * @throws \Exception
     */
    public function getActiveOffersFromCategory(int $id): OfferSearchResultInterface
    {
        $criteria = $this->searchCriteriaBuilder;
        $categoryFilter = $this->createFilter('category_id', 'eq', $id);
        $categoryGroup = $this->filterGroupBuilder->addFilter($categoryFilter)->create();

        $fromDateValueFilter = $this->createFilter('from_date', 'gteq', (new \DateTime())->format('Y-m-d H:i:s'));
        $fromDateNullFilter = $this->createFilter('from_date', 'null', null);
        $fromDateGroup = $this->filterGroupBuilder->addFilter($fromDateValueFilter)->addFilter($fromDateNullFilter)->create();

        $toDateValueFilter = $this->createFilter('to_date', 'gteq', (new \DateTime())->format('Y-m-d H:i:s'));
        $toDateNullFilter = $this->createFilter('to_date', 'null', null);
        $toDateGroup = $this->filterGroupBuilder->addFilter($fromDateValueFilter)->addFilter($fromDateNullFilter)->create();

        $criteria->setFilterGroups([$categoryGroup, $fromDateGroup, $toDateGroup]);
        return $this->offerRepository->getList($criteria->create());
    }

    /**
     * @param string $field
     * @param string $condition
     * @param $value
     * @return \Magento\Framework\Api\AbstractSimpleObject
     */
    protected function createFilter(string $field, string $condition, $value): AbstractSimpleObject
    {
        return $this->filterBuilder
            ->setField($field)
            ->setConditionType($condition)
            ->setValue($value)
            ->create();
    }
}
