<?php

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Devicetoken
 * @package Aheadworks\MobilePushNotification\Model
 */
class Devicetoken extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Aheadworks\MobilePushNotification\Model\Resource\Devicetoken');
    }
}


