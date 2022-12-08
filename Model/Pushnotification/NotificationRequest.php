<?php

namespace Aheadworks\MobilePushNotification\Model\Pushnotification;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Aheadworks\MobilePushNotification\Model\DeviceTokenFactory;
use Aheadworks\MobilePushNotification\Model\Api\Request\Curl;

/**
 * Notification request for fcm.
 */
class NotificationRequest
{
    /**#@+
     * Info constants
     */
    private const DEFAULT_API_URL = 'https://fcm.googleapis.com/fcm/send';
    /**#@-*/

    /**
     * @var CollectionFactory
     */
    private $customerFactory;

    /**
     * @var Curl
     */
    private $curlRequest;

    /**
     * @var DeviceTokenFactory
     */
    private $deviceTokenFactory;

    /**
     * Push notification Model constructor
     *
     * @param CollectionFactory $customerFactory
     * @param Curl $curlRequest
     * @param DeviceTokenFactory $deviceTokenFactory
     */
    public function __construct(
        CollectionFactory $customerFactory,
        Curl $curlRequest,
        DeviceTokenFactory $deviceTokenFactory
    ) {
        $this->customerFactory = $customerFactory;
        $this->curlRequest = $curlRequest;
        $this->deviceTokenFactory = $deviceTokenFactory;
    }

    /**
     * Send notification API
     *
     * @param string $title
     * @param string $message
     * @param string $image
     * @return array
     */
    public function sendNotification($title, $message, $image)
    {
        $registrationIds = [];
        $sendResponse = null;
        $customerToken = $this->getCustomerToken();
        if (!empty($customerToken->getData())) {
            foreach ($customerToken->getData() as $customerTokenvalue) {
                if (isset($customerTokenvalue['aw_mobile_device_token'])
                    && !empty($customerTokenvalue['aw_mobile_device_token'])
                ) {
                     $registrationIds[] = $customerTokenvalue['aw_mobile_device_token'];
                }
            }
        }

        $devicetokenCollection = $this->deviceTokenFactory->create()->getCollection();
        foreach ($devicetokenCollection as $devicetokenValue) {
            if (isset($devicetokenValue['device_token']) && !empty($devicetokenValue['device_token'])) {
                $registrationIds[] = $devicetokenValue['device_token'];
            }
        }
        $registrationUniqueIds = array_values(array_unique($registrationIds));
        if (!empty($registrationIds)) {
            $msg = [
                'title' => $title,
                'body' =>  $message,
                'image' => $image,
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

    /**
     * Send customer collection of aw mobile device token
     *
     * @return array
     */
    public function getCustomerToken()
    {
        $AwMobileDeviceToken = $this->customerFactory->create();
        $AwMobileDeviceToken->addAttributeToFilter("aw_mobile_device_token", ["neq" => null]);

        return $AwMobileDeviceToken;
    }
}
