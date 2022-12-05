<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Backend\Block\Widget\Grid\Extended;
use Aheadworks\MobilePushNotification\Model\ResourceModel\Pushnotification\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Push notification history
 */
class History extends Extended
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var Data
     */
    private $backendHelper;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('view_notification_grid');
        $this->setDefaultSort('created_at', 'desc');
        $this->setSortable(true);
        $this->setPagerVisibility(true);
        $this->setFilterVisibility(false);
    }

    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            ['header' => __('ID'), 'index' => 'id', 'type' => 'number', 'width' => '100px']
        );
        $this->addColumn(
            'message_title',
            [
                'header' => __('Message Title'),
                'index' => 'message_title',
            ]
        );
        $this->addColumn(
            'message',
            [
                'header' => __('Message'),
                'index' => 'message',
            ]
        );
        $this->addColumn(
            'notification_image',
            [
                'header' => __('Image'),
                'index' => 'notification_image',
                'type' => 'notification_image',
                'frame_callback' => [$this, 'callbackImage']
            ]
        );

        return parent::_prepareColumns();
    }

    public function callbackImage($value)
    {
        if (empty($value)) {
            return '';
        }

        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $width = 70;
        
        return "<img src='" . $mediaUrl . $value . "' width='" . $width . "'/>";
    }
}
