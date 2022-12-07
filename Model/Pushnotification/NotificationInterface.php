<?php

namespace Aheadworks\MobilePushNotification\Model\Pushnotification;

use Magento\Customer\Model\CustomerFactory;
use Aheadworks\MobilePushNotification\Model\DevicetokenFactory;
use Aheadworks\MobilePushNotification\Model\Api\Request\Curl;

/**
 * Notification interface for fcm.
 */
class NotificationInterface
{
    /**#@+
     * Info constants
     */
    private const DEFAULT_API_URL = 'https://fcm.googleapis.com/fcm/send';
    /**#@-*/

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var Curl
     */
    private $curlRequest;

    /**
     * @var DevicetokenFactory
     */
    private $devicetokenFactory;

    /**
     * Push notification Model constructor
     *
     * @param CustomerFactory $customerFactory
     * @param Curl $curlRequest
     * @param DevicetokenFactory $devicetokenFactory
     */
    public function __construct(
        CustomerFactory $customerFactory,
        Curl $curlRequest,
        DevicetokenFactory $devicetokenFactory
    ) {
        $this->customerFactory = $customerFactory;
        $this->curlRequest = $curlRequest;
        $this->devicetokenFactory = $devicetokenFactory;
    }

    /**
     * Send notification API
     *
     * @param string $messageTitle
     * @param string $message
     * @param string $pushnotificationImg
     * @return array
     */
    public function sendNotification($messageTitle, $message, $pushnotificationImg)
    {
        $registrationIds = [];
        $sendResponse = null;
        $customerObj = $this->customerFactory->create()->getCollection()
        ->addAttributeToFilter("aw_mobile_device_token", ["neq" => null]);

        if (!empty($customerObj->getData())) {
            foreach ($customerObj->getData() as $customerObjvalue) {
                if (isset($customerObjvalue['aw_mobile_device_token'])
                    && !empty($customerObjvalue['aw_mobile_device_token'])
                ) {
                     $registrationIds[] = $customerObjvalue['aw_mobile_device_token'];
                }
            }
        }

        $devicetokenCollection = $this->devicetokenFactory->create()->getCollection();
        foreach ($devicetokenCollection as $devicetokenValue) {
            if (isset($devicetokenValue['device_token']) && !empty($devicetokenValue['device_token'])) {
                $registrationIds[] = $devicetokenValue['device_token'];
            }
        }
        $registrationUniqueIds = array_values(array_unique($registrationIds));
        if (!empty($registrationIds)) {
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

            $sendResponse = $this->curlRequest->request(self::DEFAULT_API_URL, json_encode($payload), 'POST');

            return $sendResponse;

        } else {
            
            $sendResponse = "notoken";
            
            return $sendResponse;

        }
    }
}
