<?php

namespace Belca\Support;

/**
 * The abstract class of an abstract enumeration.
 * Uses the default constant.
 */
abstract class AbstractEnum extends AbstractConstants
{
    /**
     * A default value of the default constant.
     *
     * @var mixed
     */
    const DEFAULT = null;

    /**
     * Returns all constants of the class without a default value.
     *
     * @return array
     */
    public static function getConstants(): array
    {
        $rc = new \ReflectionClass(get_called_class());

        /** @var array $consts **/
        $consts = $rc->getConstants();

        unset($consts['DEFAULT']);

        return $consts;
    }

    /**
     * Returns all constants of parent classes without a default value.
     *
     * @return array
     */
    public static function getParentConstants(): array
    {
        $rc = new \ReflectionClass(get_parent_class(static::class));

        /** @var array $consts **/
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
