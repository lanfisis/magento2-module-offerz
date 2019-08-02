<?php

namespace Burdz\Offerz\Uploader;

use Magento\Framework\File\Mime;
use Magento\Framework\File\Uploader;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Exception\LocalizedException;

/**
 * @category  Burdz
 * @package   Burdz\Offerz
 * @author    David Buros <david.buros@gmail.com>
 * @licence   The Unlicense
 */
class ImageUploader extends Uploader
{
    /**
     * @var null|string[]
     */
    protected $_allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

    /**
     * @var int
     */
    protected $maxFileSize = 2097152;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * @param string|array $fileId
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\File\Mime|null $fileMime
     * @throws \Exception
     */
    public function __construct(
        $fileId,
        Filesystem $filesystem,
        Mime $fileMime = null
    ) {
        $this->filesystem = $filesystem;
        parent::__construct($fileId, $fileMime);
    }

    /**
     * @param string $filePath
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validateMaxSize(string $filePath): void
    {
        $directory = $this->filesystem->getDirectoryRead(DirectoryList::SYS_TMP);
        if ($this->maxFileSize > 0 && $directory->stat($directory->getRelativePath($filePath))['size'] > $this->maxFileSize * 1024) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The file you\'re uploading exceeds the server size limit of %1 kilobytes.', $this->_maxFileSize)
            );
        }
    }
}
