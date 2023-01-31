<?php
namespace Aheadworks\MobilePushNotification\Model\Upload;

use Magento\MediaStorage\Model\File\UploaderFactory;
use Aheadworks\MobilePushNotification\Model\Upload\UploaderPath;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 *  Upload image for push notification
 */
class ImageUploader
{
    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var Info
     */
    private $info;

    /**
     * @var UploaderPath
     */
    private $uploaderPath;

    /**
     * @param UploaderFactory $uploaderFactory
     * @param UploaderPath $uploaderPath
     * @param Info $info
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        UploaderPath $uploaderPath,
        Info $info
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->uploaderPath = $uploaderPath;
        $this->info = $info;
    }

    /**
     * Save file to temp directory
     *
     * @param string $fileId
     * @return array
     */
    public function saveFileToTmpDir($fileId)
    {
        try {
            $result = ['file' => '', 'size' => '', 'name' => '', 'path' => '', 'type' => ''];
            $uploaderPath = $this->uploaderPath->getPathName();
            $mediaDirectory = $this->info
                ->getMediaDirectory()
                ->getAbsolutePath($uploaderPath);
            $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
            $uploader
                ->setAllowRenameFiles(true)
                ->setAllowedExtensions($this->getAllowedFileExtensions());
            $result = array_intersect_key($uploader->save($mediaDirectory), $result);

            $result['url'] = '/'. DirectoryList::MEDIA. '/' . $uploaderPath . '/' . $result['file'];
            $result['file_name'] = $result['file'];
            $result['id'] = base64_encode($result['file_name']);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $result;
    }

    /**
     * Add file extension validation
     *
     * @return string[]
     */
    public function getAllowedFileExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'png'];
    }
}
