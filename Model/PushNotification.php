<?php

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Push notification model.
 */
class PushNotification extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\Aheadworks\MobilePushNotification\Model\ResourceModel\PushNotification::class);
    }
}
