<?php

namespace Aheadworks\MobilePushNotification\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Device token resource model.
 */
class Devicetoken extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('aw_mobile_device_token', 'id');
    }
}
