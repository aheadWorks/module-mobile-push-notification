<?php

namespace Aheadworks\MobilePushNotification\Model\ResourceModel\Pushnotification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Push notification collection.
 */
class Collection extends AbstractCollection
{
    /**
     * Define model & ResourceModel model
     */
    protected function _construct()
    {
        $this->_init(
            \Aheadworks\MobilePushNotification\Model\Pushnotification::class,
            \Aheadworks\MobilePushNotification\Model\ResourceModel\Pushnotification::class
        );
    }
}
