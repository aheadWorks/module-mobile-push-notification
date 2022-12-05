<?php

namespace Aheadworks\MobilePushNotification\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Aheadworks\MobilePushNotification\Model\Checkmodule;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\Module\Manager;

/**
 * Test module status.
 */
class CheckmoduleTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var Checkmodule
     */
    protected $checkModule;

    /**
     * @var Manager
     */
    protected $moduleManager;

    /**
     * @var string
     */
    protected $expectedMessage;

    /**
     * Initialize model
     */
    public function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        $this->checkModule = $this->objectManager->getObject(Checkmodule::class);
        $this->moduleManager = $this->objectManager->getObject(Manager::class);
        if ($this->moduleManager->isEnabled('Aheadworks_MobilePushNotification')) {
            $this->expectedMessage = true;
        } else {
            $this->expectedMessage = false;
        }
    }

    public function testCheckModule()
    {
        $this->assertEquals($this->expectedMessage, $this->checkModule->checkModule());
    }
}
