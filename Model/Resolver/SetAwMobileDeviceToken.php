<?php

declare(strict_types=1);

namespace Aheadworks\MobilePushNotification\Model\Resolver;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Aheadworks\MobilePushNotification\Model\SetDeviceToken;

/**
 * Set aw mobile device token resolver.
 */
class SetAwMobileDeviceToken implements ResolverInterface
{
    /**
     * @var SetDeviceToken
     */
    private $setDeviceToken;

    /**
     * @param SetDeviceToken $setDeviceToken
     */
    public function __construct(
        SetDeviceToken $setDeviceToken
    ) {
        $this->setDeviceToken = $setDeviceToken;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        return $this->setDeviceToken->execute($args['input']);
    }
}
