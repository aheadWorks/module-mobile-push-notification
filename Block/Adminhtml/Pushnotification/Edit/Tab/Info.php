<?php

namespace Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

/**
 * Push notification info
 */
class Info extends Generic implements TabInterface
{
    /**#@+
     * Info constants
     */
    private const IMMEDIATELY = 'Immediately';
    private const ONCE = 'Once';
    private const DAILY = 'Daily';
    private const WEEKLY = 'Weekly';
    private const MONTHLY = 'Monthly';
    private const OPEN_A_PRODUCT = 'Open a product';
    private const OPEN_A_COLLECTION = 'Open a collection';
    private const ESCAWAY_SHOP_HOME = 'Escaway shop(Home)';
    private const CATEGORIES = 'Categories';
    private const MY_PROFILE = 'My Profile';
    /**#@-*/

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
        $this->_formFactory = $formFactory;
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
                'after_element_html' => '<script type="text/javascript">
                    document.getElementById("message_title").setAttribute("maxlength", "48"
                    )</script>',
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
                'values'    => ['' => __('Select option'),
                                    'immediately' => $this->getImmediately(),
                                    'once'   => $this->getOnce(),
                                    'daily'   => $this->getDaily(),
                                    'weekly'   => $this->getWeekly(),
                                    'monthly'   => $this->getMonthly()
                                ]

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
                'values'    => ['' => 'Select Feature To Open',
                                    'openaproduct' => $this->getOpenaproduct(),
                                    'openacollection'   => $this->getOpenacollection(),
                                    'escawayshophome'   => $this->getEscawayshophome(),
                                    'categories'   => $this->getCategories(),
                                    'myprofile'   => $this->getMyprofile()
                                ]

            ]
        );

        $fieldset->addType(
            'previewtype',
            \Aheadworks\MobilePushNotification\Block\Adminhtml\Pushnotification\Edit\Tab\Renderer\Image::class
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
     * Tab can show
     *
     * @return string
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab can hidden
     *
     * @return string
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Show immediately
     *
     * @return string
     */
    public function getImmediately()
    {
        return self::IMMEDIATELY;
    }

    /**
     * Show once
     *
     * @return string
     */
    public function getOnce()
    {
        return self::ONCE;
    }

    /**
     * Show daily
     *
     * @return string
     */
    public function getDaily()
    {
        return self::DAILY;
    }

    /**
     * Show weekly
     *
     * @return string
     */
    public function getWeekly()
    {
        return self::WEEKLY;
    }

    /**
     * Show monthly
     *
     * @return string
     */
    public function getMonthly()
    {
        return self::MONTHLY;
    }

    /**
     * Show open a product
     *
     * @return string
     */
    public function getOpenaproduct()
    {
        return self::OPEN_A_PRODUCT;
    }

    /**
     * Show open a collection
     *
     * @return string
     */
    public function getOpenacollection()
    {
        return self::OPEN_A_COLLECTION;
    }

    /**
     * Show escaway shop home
     *
     * @return string
     */
    public function getEscawayshophome()
    {
        return self::ESCAWAY_SHOP_HOME;
    }

    /**
     * Show categories
     *
     * @return string
     */
    public function getCategories()
    {
        return self::CATEGORIES;
    }

    /**
     * Show my profile
     *
     * @return string
     */
    public function getMyprofile()
    {
        return self::MY_PROFILE;
    }
}
