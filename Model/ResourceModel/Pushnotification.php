<?php

namespace Aheadworks\MobilePushNotification\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Pushnotification
 * @package Aheadworks\MobilePushNotification\Model\ResourceModel
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
