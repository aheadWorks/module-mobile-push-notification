<?php

namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\PushNotification;

use Aheadworks\MobilePushNotification\Model\PushNotification\NotificationRequest;
use Magento\Backend\App\Action\Context;
use Aheadworks\MobilePushNotification\Model\PushNotificationFactory;
use Aheadworks\MobilePushNotification\Model\Upload\Info;
use Magento\Framework\App\Action\Action;
use Aheadworks\MobilePushNotification\Model\Upload\UploaderPath;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Save push notification data
 */
class Save extends Action
{
   /**
    * @var NotificationRequest
    */
    private $notificationRequest;

   /**
    * @var PushNotificationFactory
    */
    private $pushnotificationFactory;

    /**
     * @var Info
     */
    private $infoImage;

    /**
     * @var UploaderPath
     */
    private $uploaderPath;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

   /**
    * @param NotificationRequest $notificationRequest
    * @param PushNotificationFactory $pushnotificationFactory
    * @param Info $infoImage
    * @param UploaderPath $uploaderPath
    * @param StoreManagerInterface $storeManager
    * @param Context $context
    */
    public function __construct(
        NotificationRequest $notificationRequest,
        PushNotificationFactory $pushnotificationFactory,
        Info $infoImage,
        UploaderPath $uploaderPath,
        StoreManagerInterface $storeManager,
        Context $context
    ) {
        $this->notificationRequest = $notificationRequest;
        $this->pushnotificationFactory = $pushnotificationFactory;
        $this->infoImage = $infoImage;
        $this->uploaderPath = $uploaderPath;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Push notification index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($this->_redirect->getRefererUrl()); // phpcs:ignore
        $data = $this->getRequest()->getPostValue();
        
        if (!empty($data['message_title']) && !empty($data['message'])) {
            $messageTitle = $data['message_title'];
            $message = $data['message'];

            if (!empty($data['notification_image'])) {
                if (isset($data['notification_image']['0']['path'])) {
                    $imgName = $data['notification_image']['0']['name'];
                    $data['notification_image'] = $this->uploaderPath->getPathName().'/'.$imgName;
                    $notificationImageUrl = $this->infoImage->getMediaUrl($imgName);
                } else {
                    $imgName = $data['notification_image']['0']['url'];
                    $data['notification_image'] = $imgName;
                    $currentUrl = $this->storeManager->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
                    $newcurrentUrl = rtrim($currentUrl, '/');
                    $notificationImageUrl = $newcurrentUrl.$imgName;
                }
            } else {
                $notificationImageUrl = '';
            }

            $notificationModel = $this->pushnotificationFactory->create();
            $sendNotification = $this->notificationRequest->sendNotification(
                $messageTitle,
                $message,
                $notificationImageUrl
            );

            if ($sendNotification == "success") {
                $notificationModel->setData($data)->save();
                $this->messageManager->addSuccessMessage(__('Notification send successfully'));
            } elseif ($sendNotification == "notoken") {
                $this->messageManager->addErrorMessage(__('There is no mobile device token found.'));
            } else {
                $this->messageManager->addErrorMessage(__('Something went wrong while sending the notification'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Something went wrong while sending the notification'));
        }
        
        return $resultRedirect;
    }
}
