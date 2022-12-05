<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab\Renderer;

use Magento\Framework\View\Asset\Repository;

/**
 * Push notification image
 */
class Image extends \Magento\Framework\Data\Form\Element\Image
{
    const PREVIEW_IMAGE_URL = 'images/preview.png';

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @param Repository $repository
     */
    public function __construct(
        Repository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * Push notification index action
     */
    public function getElementHtml()
    {
        $imageName = $this->getPreviewimage();
        $imaeUrl = $this->repository->getUrl("Aheadworks_MobilePushNotification::".$imageName);
        $html = '<div class="previewsection"><label id="previewtext"></label>
        <label id="previewmsg"></label></div><image src="'.$imaeUrl.'"/>';
        return $html;
    }

    /**
     * Show preview image
     *
     * @return string
     */
    public function getPreviewimage()
    {
        return self::PREVIEW_IMAGE_URL;
    }
}
