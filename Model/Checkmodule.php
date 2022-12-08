<?php

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Module\Manager;

/**
 * Check module status.
 */
class Checkmodule
{
    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * Check module constructor
     *
     * @param Manager $moduleManager
     */
    public function __construct(
        Manager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    /**
     * Check if module is enabled or not
     */
    public function moduleStatus()
    {
        if ($this->moduleManager->isEnabled('Aheadworks_MobilePushNotification')) {
            return true;
        } else {
            return false;
        }
    }
}
