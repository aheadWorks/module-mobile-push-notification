<?php
namespace Aheadworks\MobilePushNotification\Block\Adminhtml\PushNotification\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Save push notification button
 */
class Save implements ButtonProviderInterface
{
    /**
     * Get button data on push notification
     *
     * @return array
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
