<?php

namespace Aheadworks\MobilePushNotification\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Devicetoken
 * @package Aheadworks\MobilePushNotification\Model\Resource
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
