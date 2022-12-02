<?php
declare (strict_types = 1);

namespace Aheadworks\MobilePushNotification\Model\Resolver;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Aheadworks\MobilePushNotification\Model\CheckDeviceToken;

/**
 * Class SetAwMobileDeviceToken
 * @package Aheadworks\MobilePushNotification\Model\Resolver
 */
class SetAwMobileDeviceToken implements ResolverInterface
{
     /**
     * @var CheckDeviceToken
     */
    private $checkDeviceToken;

    /**
     * @param CheckDeviceToken $checkDeviceToken
     */
    public function __construct(
        CheckDeviceToken $checkDeviceToken
    ) {
        $this->checkDeviceToken = $checkDeviceToken;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        return $this->checkDeviceToken->execute($args['input']);
    }
}
