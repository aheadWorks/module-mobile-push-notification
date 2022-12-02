<?php

namespace Aheadworks\MobilePushNotification\Model\Resource\Devicetoken;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Aheadworks\MobilePushNotification\Model\Resource\Devicetoken
 */
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Aheadworks\MobilePushNotification\Model\Devicetoken',
            'Aheadworks\MobilePushNotification\Model\Resource\Devicetoken'
        );
    }
}
