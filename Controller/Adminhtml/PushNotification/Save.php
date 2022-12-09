<?php

namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\PushNotification;

use Aheadworks\MobilePushNotification\Model\PushNotification\NotificationRequest;
use Magento\Backend\App\Action\Context;
use Aheadworks\MobilePushNotification\Model\PushNotificationFactory;
use Aheadworks\MobilePushNotification\Model\Upload\Info;
use Magento\Framework\App\Action\Action;
use Aheadworks\MobilePushNotification\Model\Upload\UploaderPath;

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
    * @param NotificationRequest $notificationRequest
    * @param PushNotificationFactory $pushnotificationFactory
    * @param Info $infoImage
    * @param UploaderPath $uploaderPath
    * @param Context $context
    */
    public function __construct(
        NotificationRequest $notificationRequest,
        PushNotificationFactory $pushnotificationFactory,
        Info $infoImage,
        UploaderPath $uploaderPath,
        Context $context
    ) {
        $this->notificationRequest = $notificationRequest;
        $this->pushnotificationFactory = $pushnotificationFactory;
        $this->infoImage = $infoImage;
        $this->uploaderPath = $uploaderPath;
        parent::__construct($context);
    }

    /**
     * Push notification index action
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        $data = $this->getRequest()->getPostValue();
        
        if (!empty($data['message_title']) && !empty($data['message'])) {
            $messageTitle = $data['message_title'];
            $message = $data['message'];

            if (!empty($data['notification_image'])) {
                $imgName = $data['notification_image']['0']['file_name'];
                $data['notification_image'] = $this->uploaderPath->getPathName().'/'.$imgName;
                $notificationImageUrl = $this->infoImage->getMediaUrl($imgName);
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
