<?php

namespace Burdz\Offerz\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Registry;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Backend\App\Action\Context;
use Magento\Theme\Model\Design\Config\FileUploader\FileProcessor;
use Burdz\Offerz\Ui\Filter\OfferPostDataProcessor;
use Burdz\Offerz\Api\Data\OfferInterfaceFactory;
use Burdz\Offerz\Api\OfferRepositoryInterface;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
abstract class Offer extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\Registry,
     */
    protected $registry;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Magento\Theme\Model\Design\Config\FileUploader\FileProcessor
     */
    protected $fileProcessor;

    /**
     * @var \Burdz\Offerz\Ui\Filter\OfferPostDataProcessor
     */
    protected $postDataProcessor;

    /**
     * @var \Burdz\Offerz\Api\Data\OfferInterfaceFactory
     */
    protected $offerFactory;

    /**
     * @var \Burdz\Offerz\Api\OfferRepositoryInterface
     */
    protected $offerRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Theme\Model\Design\Config\FileUploader\FileProcessor $fileProcessor
     * @param \Burdz\Offerz\Ui\Filter\OfferPostDataProcessor $postDataProcessor
     * @param \Burdz\Offerz\Api\Data\OfferInterfaceFactory $offerFactory
     * @param \Burdz\Offerz\Api\OfferRepositoryInterface $offerRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        Registry $registry,
        DataPersistorInterface $dataPersistor,
        FileProcessor $fileProcessor,
        OfferPostDataProcessor $postDataProcessor,
        OfferInterfaceFactory $offerFactory,
        OfferRepositoryInterface $offerRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->registry = $registry;
        $this->dataPersistor = $dataPersistor;
        $this->fileProcessor = $fileProcessor;
        $this->postDataProcessor = $postDataProcessor;
        $this->offerFactory = $offerFactory;
        $this->offerRepository = $offerRepository;
        parent::__construct($context);
    }

    /**
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @param string $level
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage(Page $resultPage, string $level): Page
    {
        return $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Burdz'), __('Burdz'))
            ->addBreadcrumb(__('Offerz'), __('Offerz'))
            ->addBreadcrumb(__($level), __($level));
    }
}
