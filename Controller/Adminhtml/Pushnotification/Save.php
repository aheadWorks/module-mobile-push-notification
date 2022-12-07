<?php

namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\Pushnotification;

use Aheadworks\MobilePushNotification\Model\Pushnotification\NotificationInterface;
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
    * @var NotificationInterface
    */
    private $notificationInterface;

   /**
    * @var PushnotificationFactory
    */
    private $pushnotificationFactory;

    /**
     * @var Info
     */
    private $infoImage;

   /**
    * @param NotificationInterface $notificationInterface
    * @param PushnotificationFactory $pushnotificationFactory
    * @param Info $infoImage
    * @param Context $context
    */
    public function __construct(
        NotificationInterface $notificationInterface,
        PushnotificationFactory $pushnotificationFactory,
        Info $infoImage,
        Context $context
    ) {
        $this->notificationInterface = $notificationInterface;
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
                $data['notification_image'] = self::NOTIFICATIONIMAGE.'/'.$data['notification_image']['0']['file_name'];
                $pushnotificationImg = $this->infoImage->getMediaUrl($data['notification_image']);
            } else {
                $pushnotificationImg = '';
            }

            $newsModel = $this->pushnotificationFactory->create();
            $sendNotification = $this->notificationInterface->sendNotification(
                $messageTitle,
                $message,
                $pushnotificationImg
            );

            if ($sendNotification == "success") {
                $newsModel->setData($data);
                $newsModel->save($data);
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
