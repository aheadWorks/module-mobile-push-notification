<?php
declare(strict_types=1);

namespace Aheadworks\MobilePushNotification\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Aheadworks\MobilePushNotification\Model\DevicetokenFactory;

/**
 * Class CheckDeviceToken
 * @package Aheadworks\MobilePushNotification\Model
 */
class CheckDeviceToken
{
    /**
     * @var DevicetokenFactory
     */
    protected $devicetokenFactory;

    /**
     * @param DevicetokenFactory $devicetokenFactory
     */
    public function __construct(
        DevicetokenFactory $devicetokenFactory
    ) {
        $this->devicetokenFactory = $devicetokenFactory;
    }

    /**
     * @param array $data
     * @throws GraphQlInputException
     */
    public function execute(array $data = null)
    {
        $message = [];
        try {
            $this->vaildateData($data);
            $devicetokenModel = $this->devicetokenFactory->create();
            $devicetokenModel->setData($data);
            $devicetokenModel->save($data);
             $response = [
            	'message' =>  "Device token has successfully save."
        	];
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        return $response;
    }

    /**
     * Handle bad request.
     *
     * @param array $data
     * @throws LocalizedException
     */
    private function vaildateData(array $data = null)
    {
        if (empty($data['customer_id']) && empty($data['device_id'])){
            throw new LocalizedException(__('Must be set customer id or device id'));
        }elseif (!isset($data['device_token'])){
        	throw new LocalizedException(__('Must be set device token'));
        }
    }
}

