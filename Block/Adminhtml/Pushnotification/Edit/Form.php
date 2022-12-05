<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Push notification form
 */
class Form extends Generic
{
    /**
     * Class _prepareForm
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'    => 'edit_form',
                    'enctype' => 'multipart/form-data',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
