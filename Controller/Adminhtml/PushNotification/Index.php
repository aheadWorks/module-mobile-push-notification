<?php

namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\PushNotification;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences\AbstractAction;

/**
 * Push notification index controller
 */
class Index extends AbstractAction
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Push notification index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Aheadworks_MobilePushNotification::push_notification'
        )->addBreadcrumb(
            __('Push Notifications'),
            __('Push Notifications')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Push Notifications'));

        return $resultPage;
    }
}
