<?php

namespace Aheadworks\MobilePushNotification\Model\ResourceModel\Devicetoken;

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
            \Aheadworks\MobilePushNotification\Model\Devicetoken::class,
            \Aheadworks\MobilePushNotification\Model\ResourceModel\Devicetoken::class
        );
    }
}
