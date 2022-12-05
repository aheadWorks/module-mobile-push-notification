<?php

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Module\Manager;

/**
 * Class Checkmodule
 * @package Aheadworks\MobilePushNotification\Model
 */
class Checkmodule extends AbstractModel
{
    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * @param Manager $moduleManager
     */
    public function __construct(
        Manager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    public function checkModule()
    {
        if ($this->moduleManager->isEnabled('Aheadworks_MobilePushNotification')) {
            return true;
        } else {
            return false;
        }
    }
}
