<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\PushNotification;

/**
 * Preview notification on image
 */
class PreviewNotification extends \Magento\Backend\Block\Template
{
    private const PREVIEW_IMAGE = 'images/preview.png';

   /**
    * Get preview image
    *
    * @return string
    */
    public function getPreviewImage()
    {
        return self::PREVIEW_IMAGE;
    }
}
