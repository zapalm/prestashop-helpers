<?php
/**
 * Helper classes for PrestaShop CMS.
 *
 * @author    Maksim T. <zapalm@yandex.com>
 * @copyright 2018 Maksim T.
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/zapalm/prestashopHelpers GitHub
 * @link      https://prestashop.modulez.ru/en/tools-scripts/53-helper-classes-for-prestashop.html Homepage
 */

namespace zapalm\prestashopHelpers\components\cache;

/**
 * Base class of a cache system.
 *
 * @version 0.5.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
abstract class BaseCache extends \Cache
{
    /** @var static Instance. */
    protected static $instance;

    /** @var string Caching system class name. */
    private static $cachingSystemClassName;

    /**
     * Protected constructor.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function __construct()
    {
        // The realization do not need.
    }

    /**
     * Protected cloner.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function __clone()
    {
        // The realization do not need.
    }

    /**
     * Returns an instance of a cache system.
     *
     * @return static The instance.
     *
     * @see setCachingSystemClassName() To set a caching system class name.
     *
     * @throws \LogicException If a caching system class name was not set.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static::$cachingSystemClassName();
        }

        return static::$instance;
    }

    /**
     * Sets a caching system class name.
     *
     * @param string $className The class name.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function setCachingSystemClassName($className)
    {
        static::$cachingSystemClassName = $className;
    }

    /**
     * Gets a caching system class name.
     *
     * @return string The class name.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getCachingSystemClassName()
    {
        return self::$cachingSystemClassName;
    }
}