<?php
/**
 * @package   ImpressPages
 */

namespace Ip\Internal\Admin;

class Service
{
    public static function isSafeMode()
    {
        return \Ip\Internal\Admin\Model::isSafeMode();

    }

    public static function adminId()
    {
        return Model::getUserId();
    }

}
