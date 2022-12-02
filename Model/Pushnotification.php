<?php

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Pushnotification
 * @package Aheadworks\MobilePushNotification\Model
 */
class Pushnotification extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Aheadworks\MobilePushNotification\Model\ResourceModel\Pushnotification');
    }
}
