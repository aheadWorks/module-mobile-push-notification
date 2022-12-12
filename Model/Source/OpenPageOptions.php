<?php

namespace Aheadworks\MobilePushNotification\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Options for open page
 */
class OpenPageOptions implements OptionSourceInterface
{
    /**
     * Get the options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('-- Select Feature To Open --'), 'value' => ''],
            ['label' => __('Open a product'), 'value' => 'openaproduct'],
            ['label' => __('Open a collection'), 'value' => 'openacollection'],
            ['label' => __('Home Page'), 'value' => 'homepage'],
            ['label' => __('Categories'), 'value' => 'categories'],
            ['label' => __('My Profile'), 'value' => 'my_profile']
        ];
    }
}
