<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab\Renderer;

use Magento\Framework\View\Asset\Repository;

/**
 * Class Image
 * @package Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab\Renderer
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
     * {@inheritdoc}
     */
    public function getElementHtml()
    {
        $imageName = self::PREVIEW_IMAGE_URL;
        $imaeUrl = $this->repository->getUrl("Aheadworks_MobilePushNotification::".$imageName);
        $html = '<div class="previewsection"><label id="previewtext"></label><label id="previewmsg"></label></div><image src="'.$imaeUrl.'"/>';
        return $html;
    }
}
