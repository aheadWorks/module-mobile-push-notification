<?php
namespace Aheadworks\MobilePushNotification\Model\Upload;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Aheadworks\MobilePushNotification\Model\Upload\UploaderPath;

/**
 * Info for media image
 */
class Info
{
    private const NOTIFICATIONIMAGE = "notification_image";

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var UploaderPath
     */
    private $uploaderPath;

    /**
     * @param UrlInterface $urlBuilder
     * @param Filesystem $filesystem
     * @param UploaderPath $uploaderPath
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Filesystem $filesystem,
        UploaderPath $uploaderPath
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->filesystem = $filesystem;
        $this->uploaderPath = $uploaderPath;
    }
    /**
     * Get WriteInterface instance
     *
     * @return WriteInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getMediaDirectory()
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }
        return $this->mediaDirectory;
    }

    /**
     * Retrieve Media Url
     *
     * @param string $imagename
     * @return string
     */
    public function getMediaUrl($imagename)
    {
        $imageUrl = $this->urlBuilder->getBaseUrl() . $imagename;
        return $imageUrl;
    }
}
