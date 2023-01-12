<?php

declare(strict_types=1);

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Aheadworks\MobilePushNotification\Model\DeviceTokenFactory;

/**
 * Check device token model.
 */
class SetDeviceToken
{
    /**
     * @var DeviceTokenFactory
     */
    protected $deviceTokenFactory;

    /**
     * Check device token constructor
     *
     * @param DeviceTokenFactory $deviceTokenFactory
     */
    public function __construct(
        DeviceTokenFactory $deviceTokenFactory
    ) {
        $this->deviceTokenFactory = $deviceTokenFactory;
    }

    /**
     * Execute device token
     *
     * @param array $data
     * @return array
     * @throws GraphQlInputException
     */
    public function execute(array $data = null)
    {
        $message = [];
        try {
            $this->vaildateData($data);
            $devicetokenModel = $this->deviceTokenFactory->create();
            $devicetokenModel->setData($data);
            $devicetokenModel->save($data);
            $response = ['message' =>  "Device token has successfully save."];
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        return $response;
    }

    /**
     * Handle bad request.
     *
     * @param array $data
     * @return void
     * @throws LocalizedException
     */
    private function vaildateData(array $data = null)
    {
        if (empty($data['customer_id']) && empty($data['device_id'])) {
            throw new LocalizedException(__('Must be set customer id or device id'));
        } elseif (!isset($data['device_token'])) {
            throw new LocalizedException(__('Must be set device token'));
        }
    }
}
