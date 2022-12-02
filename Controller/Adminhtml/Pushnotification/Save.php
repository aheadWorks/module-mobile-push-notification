<?php

namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\Pushnotification;

use Aheadworks\MobilePushNotification\Model\Pushnotification\PushnotificationModel;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Aheadworks\MobilePushNotification\Model\PushnotificationFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Save
 * @package Aheadworks\MobilePushNotification\Controller\Adminhtml\Pushnotification
 */
class Save extends \Magento\Framework\App\Action\Action
{
   /**
    * @var PushnotificationModel
    */
   private $pushNotification;

   /**
    * @var DataPersistorInterface
    */
   private $dataPersistor;

   /**
    * @var Filesystem
    */
   private $fileSystem;

   /**
    * @var UploaderFactory
    */
   private $uploaderFactory;

   /**
    * @var AdapterFactory
    */
   private $adapterFactory;

   /**
    * @var PushnotificationFactory
    */
   private $pushnotificationFactory;

   /**
    * @var StoreManagerInterface
    */
   private $storeManager;

   /**
    * @param PushnotificationModel $pushNotification
    * @param DataPersistorInterface $dataPersistor
    * @param Filesystem $fileSystem
    * @param UploaderFactory $uploaderFactory
    * @param AdapterFactory $adapterFactory
    * @param PushnotificationFactory $pushnotificationFactory
    * @param StoreManagerInterface $storeManager
    * @param Context $context
    */
   public function __construct(
        PushnotificationModel $pushNotification,
        DataPersistorInterface $dataPersistor,
        Filesystem $fileSystem,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        PushnotificationFactory $pushnotificationFactory,
        StoreManagerInterface $storeManager,
        Context $context
   ){
        $this->pushNotification = $pushNotification;
        $this->dataPersistor = $dataPersistor;
        $this->fileSystem = $fileSystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->pushnotificationFactory = $pushnotificationFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
   }

   /**
    * {@inheritdoc}
    */
   public function execute()
   { 
      $resultRedirect = $this->resultRedirectFactory->create();
      $resultRedirect->setUrl($this->_redirect->getRefererUrl());
      $data = $this->getRequest()->getPostValue();
      $messageTitle = $data['message_title'];
      $message = $data['message'];
      $choose = $data['choose_action'];
      $selectAction = $data['select_action'];

      if(isset($data['notification_image']['delete'])){
         if($data['notification_image']['delete'] == 1){
             $data['notification_image'] = '';
         }
      }

      if((isset($_FILES['notification_image']['name'])) && ($_FILES['notification_image']['name'] != '') && (!isset($data['notification_image']['delete']))){
         try{
            $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'notification_image']);
            $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $imageAdapter = $this->adapterFactory->create();
            $uploaderFactory->setAllowRenameFiles(true);
            $uploaderFactory->setFilesDispersion(true);
            $mediaDirectory = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA);
            $destinationPath = $mediaDirectory->getAbsolutePath('aheadworks_mobilepushnotification_img');
            $result = $uploaderFactory->save($destinationPath);
            if(!$result){
               throw new LocalizedException(__('File cannot be saved to path: $1', $destinationPath));
            }
            $imagePath = 'aheadworks_mobilepushnotification_img' . $result['file'];
            $data['notification_image'] = $imagePath;
         }catch(\Exception $e){
             $this->messageManager->addError(__("Image not Upload Pleae Try Again"));
         }
      }

      $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
      $pushnotificationImg = $mediaUrl.$imagePath;
      $newsModel = $this->pushnotificationFactory->create();
      $sendNotification = $this->pushNotification->sendNotification($messageTitle, $message, $pushnotificationImg);
      $newsModel->setData($data);
      $newsModel->save($data);

      if($sendNotification == "success"){
         $this->messageManager->addSuccessMessage(__('Notification send successfully'));
      }else{
         $this->messageManager->addExceptionMessage(__('Something went wrong while sending the notification'));
      }

      return $resultRedirect;
   }
}
