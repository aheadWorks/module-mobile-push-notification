<?php

namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\Pushnotification;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences\AbstractAction;

/**
 * Class Index
 * @package Aheadworks\MobilePushNotification\Controller\Adminhtml\Pushnotification
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
     * {@inheritdoc}
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
