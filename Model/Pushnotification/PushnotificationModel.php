<?php

namespace Aheadworks\MobilePushNotification\Model\Pushnotification;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Exception\InputException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Aheadworks\MobilePushNotification\Model\DevicetokenFactory;

/**
 * Class PushnotificationModel
 * @package Aheadworks\MobilePushNotification\Model\Pushnotification
 */
class PushnotificationModel
{
    const DEFAULT_API_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var DevicetokenFactory
     */
    private $devicetokenFactory;

    /**
     * @param CustomerFactory $customerFactory
     * @param Context $context
     * @param Curl $curl
     * @param ScopeConfigInterface $scopeConfig
     * @param DevicetokenFactory $devicetokenFactory
     */
    public function __construct(
        CustomerFactory $customerFactory,
        Curl $curl,
        ScopeConfigInterface $scopeConfig,
        DevicetokenFactory $devicetokenFactory
    ){
        $this->customerFactory = $customerFactory;
        $this->curl = $curl;
        $this->scopeConfig = $scopeConfig;
        $this->devicetokenFactory = $devicetokenFactory;
    }

    public function sendNotification($messageTitle, $message, $pushnotificationImg)
    {
        $registrationIds = array();
        $sendResponse = null;
        $customerObj = $this->customerFactory->create()->getCollection()->addAttributeToSelect("*")->addAttributeToFilter("aw_mobile_device_token", array("neq" => null))->load();

        if(!empty($customerObj->getData())){
            foreach ($customerObj->getData() as $customerObjvalue) {
                if(isset($customerObjvalue['aw_mobile_device_token']) && !empty($customerObjvalue['aw_mobile_device_token'])){
                    $registrationIds[] = $customerObjvalue['aw_mobile_device_token'];
                }
            }
        }

        $devicetokenCollection = $this->devicetokenFactory->create()->getCollection();
        foreach($devicetokenCollection as $devicetokenValue){
            if(isset($devicetokenValue['device_token']) && !empty($devicetokenValue['device_token'])){
                $registrationIds[] = $devicetokenValue['device_token'];
            }
        }
        $registrationUniqueIds = array_values(array_unique($registrationIds));
        if(!empty($registrationIds)){
            $msg = [
                'title' => $messageTitle,
                'body' =>  $message,
                'image' => $pushnotificationImg,
                "mutable_content" => true,
                "sound" => "Tri-tone"
            ];

            $payload = [
                'registration_ids'  =>  $registrationUniqueIds,
                "priority"  => "high",
                'notification'  => $msg
            ];

            $firebaseApiKey = $this->scopeConfig->getValue('aw_mpn/aw_mpn_setting/firebase_api_key');
            $authorization = "Key=$firebaseApiKey";

            try{
                $this->curl->addHeader("Content-Type", "application/json");
                $this->curl->addHeader("Authorization",$authorization);
                $this->curl->post(self::DEFAULT_API_URL, json_encode($payload));
                $responseCode = $this->curl->getStatus();
                $response = $this->curl->getBody();
            }catch (\Exception $e){
                throw new InputException(__('Error while sending push notification'));
            }

            if($responseCode == 200) {
                $sendResponse = "success";
            }else {
                $sendResponse = "failure";
            }

            return $sendResponse;

        }else{

            return $sendResponse;
        }
    }
}