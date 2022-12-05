<?php

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Module\Manager;

/**
 * Check module status.
 */
class Checkmodule extends AbstractModel
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
     * Check module status
     */
    public function checkModule()
    {
        if ($this->moduleManager->isEnabled('Aheadworks_MobilePushNotification')) {
            return true;
        } else {
            return false;
        }
    }
}
