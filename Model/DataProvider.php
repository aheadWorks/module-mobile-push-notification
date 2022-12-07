<?php

namespace Aheadworks\MobilePushNotification\Model;

use Aheadworks\MobilePushNotification\Model\ResourceModel\Pushnotification\CollectionFactory;

/**
 *  Data Provider for UI components based on push notification
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;
    // @codingStandardsIgnoreStart
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blogCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $blogCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $blog) {
            $this->loadedData[$blog->getId()] = $blog->getData();
        }
        return $this->loadedData;
    }
}
