<?php

namespace Burdz\Offerz\Controller\Adminhtml\Offer\FileUploader;

use Burdz\Offerz\Uploader\ImageUploaderFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Exception;
use Magento\Framework\Controller\ResultFactory;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class Save extends Action
{
    const ADMIN_RESOURCE = 'Burdz_Offerz::burdz_offerz_offer_add';
    const FILE_ID = 'image_info';
    const FILE_DIR = 'offer/image';

    /**
     * @var \Burdz\Offerz\Uploader\ImageUploaderFactory
     */
    protected $imageUploaderFactory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Burdz\Offerz\Uploader\ImageUploaderFactory $imageUploaderFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        ImageUploaderFactory $imageUploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager
    ) {
        $this->imageUploaderFactory = $imageUploaderFactory;
        $this->filesystem = $filesystem;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->save(self::FILE_ID, $this->getAbsoluteTmpMediaPath());
            $result['url'] = $this->getTmpMediaUrl($result['file']);
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function getAbsoluteTmpMediaPath(): string
    {
        $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        return $mediaDirectory->getAbsolutePath(self::FILE_DIR);
    }

    /**
     * @param $fileId
     * @param $destination
     * @return array
     * @throws \Exception
     */
    protected function save($fileId, $destination): array
    {
        $uploader = $this->imageUploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);
        $uploader->addValidateCallback('size', $uploader, 'validateMaxSize');
        $result = $uploader->save($destination);
        unset($result['path']);
        return $result;
    }

    /**
     * @param string $file
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getTmpMediaUrl($file): string
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
            . self::FILE_DIR
            . '/'
            . $this->prepareFile($file);
    }

    /**
     * @param string $file
     * @return string
     */
    protected function prepareFile($file): string
    {
        return ltrim(str_replace('\\', '/', $file), '/');
    }
}
