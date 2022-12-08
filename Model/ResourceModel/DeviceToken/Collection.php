<?php

namespace Aheadworks\MobilePushNotification\Model\ResourceModel\DeviceToken;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Device token collection.
 */
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            \Aheadworks\MobilePushNotification\Model\DeviceToken::class,
            \Aheadworks\MobilePushNotification\Model\ResourceModel\DeviceToken::class
        );
    }
}
