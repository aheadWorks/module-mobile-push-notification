<?php

namespace Aheadworks\MobilePushNotification\Model\Upload;

/**
 * Push notification uploader path
 */
class UploaderPath
{
    
    private const NOTIFICATION_IMAGE = 'notification_image';
    
    /**
     * Get uploader path name
     *
     * @return string
     */
    public function getPathName()
    {
        return self::NOTIFICATION_IMAGE;
    }
}
