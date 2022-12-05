<?php

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Device token model.
 */
class Devicetoken extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\Aheadworks\MobilePushNotification\Model\ResourceModel\Devicetoken::class);
    }
}
