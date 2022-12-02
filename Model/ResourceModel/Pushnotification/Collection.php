<?php

namespace Aheadworks\MobilePushNotification\Model\ResourceModel\Pushnotification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Aheadworks\MobilePushNotification\Model\ResourceModel\Pushnotification
 */
class Collection extends AbstractCollection
{
    /**
     * Define model & ResourceModel model
     */
    protected function _construct()
    {
        $this->_init(
            'Aheadworks\MobilePushNotification\Model\Pushnotification',
            'Aheadworks\MobilePushNotification\Model\ResourceModel\Pushnotification'
        );
    }
}
