<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

/**
 * Class Tabs
 * @package Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit
 */
class Tabs extends WidgetTabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('push_notification_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Push Notification Information'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'add_push_notification',
            [
                'label' => __('Add Push Notification'),
                'title' => __('Add Push Notification'),
                'content' => $this->getLayout()->createBlock(
                    'Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab\Info'
                )->toHtml(),
                'active' => true
            ],
        );

        $this->addTab(
            'notification_history',
            [
                'label' => __('Notification History'),
                'title' => __('Notification History'),
                'content' => $this->getLayout()->createBlock(
                    'Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab\History'
                )->toHtml(),
                'active' => true
            ],
        );

        return parent::_beforeToHtml();
    }
}
