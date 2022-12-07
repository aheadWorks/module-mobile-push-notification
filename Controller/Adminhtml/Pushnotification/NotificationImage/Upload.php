<?php
namespace Aheadworks\MobilePushNotification\Controller\Adminhtml\Pushnotification\NotificationImage;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Aheadworks\MobilePushNotification\Controller\Adminhtml\Pushnotification\AbstractAction;
use Magento\Backend\App\Action\Context;
use Aheadworks\MobilePushNotification\Model\Upload\ImageUploader;

/**
 * Upload image in dir
 */
class Upload extends AbstractAction implements HttpPostActionInterface
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Upload constructor.
     *
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'notification_image');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
