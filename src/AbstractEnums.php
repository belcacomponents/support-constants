<?php

namespace Belca\Support;

abstract class AbstractEnums extends AbstractConstants
{
    const DEFAULT = null;

    /**
     * Returns all constants of the used class without a default value.
     *
     * @return array
     */
    public static function getConstants()
    {
        $rc = new \ReflectionClass(get_called_class());
        $consts = $rc->getConstants();

        unset($consts['DEFAULT']);

        return $consts;
    }

    /**
     * An alias of the getConstants() function.
     *
     * @return array
     */
    public static function getEnums()
    {
        return self::getConstants();
    }

    /**
     * Returns all constants of the parent classes without a default value.
     *
     * @return array
     */
    public static function getParentConstants()
    {
        $rc = new \ReflectionClass(get_parent_class(static::class));
        $consts = $rc->getConstants();

        unset($consts['DEFAULT']);

        return $consts;
    }

    /**
     * Returns the last default constant.
     *
     * @return mixed
     */
    public static function getDefault()
    {
        return static::DEFAULT;
    }
}
