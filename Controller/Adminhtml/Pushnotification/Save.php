<?php

namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\Pushnotification;

use Aheadworks\MobilePushNotification\Model\Pushnotification\NotificationRequest;
use Magento\Backend\App\Action\Context;
use Aheadworks\MobilePushNotification\Model\PushnotificationFactory;
use Aheadworks\MobilePushNotification\Model\Upload\Info;
use Magento\Framework\App\Action\Action;

/**
 * Save push notification data
 */
class Save extends Action
{
    private const NOTIFICATIONIMAGE = "notification_image";
    
   /**
    * @var NotificationRequest
    */
    private $notificationRequest;

   /**
    * @var PushnotificationFactory
    */
    private $pushnotificationFactory;

    /**
     * @var Info
     */
    private $infoImage;

   /**
    * @param NotificationRequest $notificationRequest
    * @param PushnotificationFactory $pushnotificationFactory
    * @param Info $infoImage
    * @param Context $context
    */
    public function __construct(
        NotificationRequest $notificationRequest,
        PushnotificationFactory $pushnotificationFactory,
        Info $infoImage,
        Context $context
    ) {
        $this->notificationRequest = $notificationRequest;
        $this->pushnotificationFactory = $pushnotificationFactory;
        $this->infoImage = $infoImage;
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
                $data['notification_image'] = self::NOTIFICATIONIMAGE.'/'.$imgName;
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
