<?php

namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\PushNotification;

use Magento\Backend\App\Action;

/**
 * Class AbstractAction
 */
abstract class AbstractAction extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Aheadworks_MobilePushNotification::push_notification';
}
