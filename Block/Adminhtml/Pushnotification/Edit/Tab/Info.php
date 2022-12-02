<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;

/**
 * Class Info
 * @package Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab
 */
class Info extends Generic implements TabInterface
{   
    const IMMEDIATELY = 'Immediately';
    const ONCE = 'Once';
    const DAILY = 'Daily';
    const WEEKLY = 'Weekly';
    const MONTHLY = 'Monthly';
    const OPEN_A_PRODUCT = 'Open a product';
    const OPEN_A_COLLECTION = 'Open a collection';
    const ESCAWAY_SHOP_HOME = 'Escaway shop(Home)';
    const CATEGORIES = 'Categories';
    const MY_PROFILE = 'My Profile';

    /**
     * @var Context
     */
    private $context;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var FormFactory
     */
    private $formFactory;

   /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {  
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Push Notification can only be sent once app is live')]
        );

        $fieldset->addField(
            'message_title',
            'text',
            [
                'name'        => 'message_title',
                'label'    => __('Message Title'),
                'required'     => true,
                'after_element_html' => '<script type="text/javascript">document.getElementById("message_title").setAttribute("maxlength", "48")</script>',
                'note' => __('Maximum number of characters is 48.')
            ]
        );
      
        $fieldset->addField(
            'message',
            'textarea',
            [
                'name'      => 'message',
                'label'     => __('Message'),
                'required'  => true,
                'style'     => 'height: 10em; width: 30em;',
                'note' => __('Maximum number of characters is 48.')
            ]
        );

        $fieldset->addField(
            'notification_image',
            'image',
            [
                'name' => 'notification_image',
                'label' => __('Upload Image'),
                'title' => __('Upload Image'),
                'required'  => false,
                'note' => 'Allow image type: jpg, jpeg, png'
            ]
        );

        $fieldset->addField(
            'choose_action',
            'select',
            [
                'name' => 'choose_action',
                'label' => __('Choose when to send'),
                'title' => __('Choose when to send'),
                'required'  => true,
                'values'    => array('' => __('Select option'),
                                    'immediately' => self::IMMEDIATELY,
                                    'once'   => self::ONCE,
                                    'daily'   => self::DAILY,
                                    'weekly'   => self::WEEKLY,
                                    'monthly'   => self::MONTHLY
                                )

            ]
        );

        $fieldset->addField(
            'select_action',
            'select',
            [
                'name' => 'select_action',
                'label' => __('Select Action'),
                'title' => __('Select Action'),
                'required'  => true,
                'values'    => array('' => 'Select Feature To Open',
                                    'openaproduct' => self::OPEN_A_PRODUCT,
                                    'openacollection'   => self::OPEN_A_COLLECTION,
                                    'escawayshophome'   => self::ESCAWAY_SHOP_HOME,
                                    'categories'   => self::CATEGORIES,
                                    'myprofile'   => self::MY_PROFILE
                                )

            ]
        );

        $fieldset->addType(
            'previewtype',
            '\Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab\Renderer\Image'
        );

        $field = $fieldset->addField(
            'previewtypes',
            'previewtype',
            [
                'name' => 'previewtypes',
                'label' => __('Preview'),
                'title' => __('Preview')
            ]
        );

        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Push Notification');
    }
 
    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Push Notification');
    }
 
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
 
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
