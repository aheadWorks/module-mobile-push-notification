<?php

namespace Aheadworks\MobilePushNotification\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Pushnotification
 * @package Aheadworks\MobilePushNotification\Model\Resource
 */
class Pushnotification extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('aw_mobile_push_notification', 'id');
    }
}
