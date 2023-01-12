<?php

declare (strict_types = 1);

namespace Aheadworks\MobilePushNotification\Setup\Patch\Data;

use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Add aw mobile device token attribute in customer.
 */
class ExternalId implements DataPatchInterface
{
   /**
    * @var ModuleDataSetupInterface
    */
    private $moduleDataSetup;

   /**
    * @var EavSetupFactory
    */
    private $eavSetupFactory;
   
   /**
    * @var ProductCollectionFactory
    */
    private $productCollectionFactory;
   
   /**
    * @var Config
    */
    private $eavConfig;
   
   /**
    * @var \Magento\Customer\Model\ResourceModel\Attribute
    */
    private $attributeResource;

   /**
    * CustomerAttribute Constructor
    * @param EavSetupFactory $eavSetupFactory
    * @param Config $eavConfig
    * @param \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
    * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig,
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource,
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
        $this->moduleDataSetup = $moduleDataSetup;
    }

   /**
    * Run code inside patch
    *
    * @return string[]
    */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->addDeviceTokenAttribute();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

   /**
    * Add device token attribute
    *
    * @throws \Magento\Framework\Exception\AlreadyExistsException
    * @throws \Magento\Framework\Exception\LocalizedException
    * @throws \Zend_Validate_Exception
    */
    public function addDeviceTokenAttribute()
    {
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'aw_mobile_device_token',
            [
                'type' => 'varchar',
                'label' => 'Device Token',
                'input' => 'hidden',
                'required' => 0,
                'visible' => 0,
                'user_defined' => 1,
                'sort_order' => 999,
                'position' => 999,
                'system' => 0,
                'is_used_in_grid' => 0,
                'is_visible_in_grid' => 0,
                'is_filterable_in_grid' => 0,
                'is_searchable_in_grid' => 0,
            ]
        );

        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'aw_mobile_device_token');
        $attribute->setData('attribute_set_id', $attributeSetId);
        $attribute->setData('attribute_group_id', $attributeGroupId);

        $this->attributeResource->save($attribute);
    }

   /**
    * Get array of patches that have to be executed prior to this.
    *
    * @return string[]
    */
    public static function getDependencies()
    {
        return [];
    }

   /**
    * Get aliases (previous names) for the patch.
    *
    * @return string[]
    */
    public function getAliases()
    {
        return [];
    }
}
