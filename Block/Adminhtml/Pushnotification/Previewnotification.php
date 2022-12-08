<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification;

/**
 * Preview notification on image
 */
class Previewnotification extends \Magento\Backend\Block\Template
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
