<?php

namespace Aheadworks\MobilePushNotification\Model\PushNotification;

use Aheadworks\MobilePushNotification\Model\DeviceTokenFactory;
use Aheadworks\MobilePushNotification\Model\Api\Request\Curl;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

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
     * @var Curl
     */
    private $curlRequest;

    /**
     * @var DeviceTokenFactory
     */
    private $deviceTokenFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Push notification Model constructor
     *
     * @param Curl $curlRequest
     * @param DeviceTokenFactory $deviceTokenFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Curl $curlRequest,
        DeviceTokenFactory $deviceTokenFactory,
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->curlRequest = $curlRequest;
        $this->deviceTokenFactory = $deviceTokenFactory;
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
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
        $registrationIds = $this->getCustomerToken();
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
        $AwMobileDeviceToken = [];
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('aw_mobile_device_token', "", 'neq')->create();
        $customerList = $this->customerRepository->getList($searchCriteria)->getItems();
        foreach ($customerList as $customerListValue) {
            $customAttribute = $customerListValue->getCustomAttributes();
            if (isset($customAttribute['aw_mobile_device_token'])
                && !empty($customAttribute['aw_mobile_device_token'])) {
                $AwMobileDeviceTokenData = $customAttribute['aw_mobile_device_token'];
                if (!empty($AwMobileDeviceTokenData->getValue())) {
                    $AwMobileDeviceToken[] = $AwMobileDeviceTokenData->getValue();
                }
            }
        }
        return $AwMobileDeviceToken;
    }
}
