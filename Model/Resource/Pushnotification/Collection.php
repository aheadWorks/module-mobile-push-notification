<?php

namespace Aheadworks\MobilePushNotification\Model\Resource\Pushnotification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Aheadworks\MobilePushNotification\Model\Resource\Pushnotification
 */
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Aheadworks\MobilePushNotification\Model\Pushnotification',
            'Aheadworks\MobilePushNotification\Model\Resource\Pushnotification'
        );
    }
}
