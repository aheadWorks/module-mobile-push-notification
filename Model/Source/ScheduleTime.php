<?php

namespace Aheadworks\MobilePushNotification\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Options for schedule time
 */
class ScheduleTime implements OptionSourceInterface
{
    /**
     * Get the options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('-- Please Select --'), 'value' => ''],
            ['label' => __('Immediately'), 'value' => 'immediately'],
            ['label' => __('Once'), 'value' => 'once'],
            ['label' => __('Daily'), 'value' => 'daily'],
            ['label' => __('Weekly'), 'value' => 'weekly'],
            ['label' => __('Monthly'), 'value' => 'monthly']
        ];
    }
}
