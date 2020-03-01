<?php

namespace Belca\Support;

/**
 * The abstract class for returning constants.
 */
abstract class AbstractConstants
{
    /**
     * Returns all constants of the class.
     *
     * @return array
     */
    public static function getConstants(): array
    {
        $rc = new \ReflectionClass(get_called_class());

        return $rc->getConstants();
    }

    /**
     * The alias of the getConstants() function.
     *
     * @return array
     */
    public static function list(): array
    {
        return static::getConstants();
    }

    /**
     * Returns an array of constants defined in the called class.
     *
     * @return array
     */
    public static function getLastConstants(): array
    {
        $parentConstants = static::getParentConstants();

        $allConstants = static::getConstants();

        return array_diff($allConstants, $parentConstants);
    }

    /**
     * Returns all constants of parent classes.
     *
     * @return array
     */
    public static function getParentConstants(): array
    {
        $rc = new \ReflectionClass(get_parent_class(static::class));

        return $rc->getConstants();
    }

    /**
     * Returns a value of a given constant if it exists,
     * else returns 'null'.
     * This is a safe method for calling constants, in otherwise
     * when you calls undefined constants you will catch an error.
     *
     * @param  string $name
     * @return mixed
     */
    public static function getConst($name)
    {
        return defined("static::$name") ? constant("static::$name") : null;
    }

    /**
     * Checks whether a given constant exists and is defined in the class.
     *
     * @param  string $name
     * @return bool
     */
    public static function isDefined($name): bool
    {
        return defined("static::$name");
    }
}
