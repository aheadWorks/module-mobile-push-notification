<?php

namespace Aheadworks\MobilePushNotification\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 * @package Aheadworks\MobilePushNotification\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Get aw_mobile_push_notification table
        $awMobilePushNotification = $installer->getTable('aw_mobile_push_notification');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($awMobilePushNotification) != true) {
            // Create aw_mobile_push_notification table
            $tablePushNotification = $installer->getConnection()
                ->newTable($awMobilePushNotification)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'message_title',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Message Title'
                )
                ->addColumn(
                    'message',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Message'
                )
                ->addColumn(
                    'notification_image',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Upload Image'
                )
                ->addColumn(
                    'choose_action',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Choose Action'
                )
                ->addColumn(
                    'select_action',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Select Action'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Created At'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Status'
                )
                ->setComment('Mobile Push Notification Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($tablePushNotification);
        }

        $awMobileDeviceToken = $installer->getTable('aw_mobile_device_token');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($awMobileDeviceToken) != true) {
            // Create aw_mobile_device_token table
            $tableDeviceToken = $installer->getConnection()
                ->newTable($awMobileDeviceToken)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    225,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    225,
                    ['nullable' => true],
                    'Customer Id'
                )
                ->addColumn(
                    'device_id',
                    Table::TYPE_TEXT,
                    225,
                    ['nullable' => true, 'default' => ''],
                    'Device Id'
                )
                ->addColumn(
                    'device_token',
                    Table::TYPE_TEXT,
                    1155,
                    ['nullable' => false, 'default' => ''],
                    'Device Token'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Created At'
                )
                ->setComment('Mobile Device Token')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($tableDeviceToken);
        }

        $installer->endSetup();
    }
}
