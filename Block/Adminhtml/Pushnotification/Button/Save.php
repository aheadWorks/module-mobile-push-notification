<?php
namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Save push notification button
 */
class Save implements ButtonProviderInterface
{
    /**
     * Get button data on push notification
     */
    public function getButtonData()
    {
        return [
            'label' => __('Send Push Notification'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save'
            ],
            'sort_order' => 50
        ];
    }
}
