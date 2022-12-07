<?php
namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification;

/**
 * Preview notification on image
 */
class Previewnotification extends \Magento\Backend\Block\Template
{

   /**
    * Block template.
    * @var string
    */
    protected $_template = 'preview_notification.phtml';

    public const PREVIEW_IMAGE = 'images/preview.png';
}
