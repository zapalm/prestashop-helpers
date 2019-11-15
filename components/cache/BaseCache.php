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
 * @version 0.3.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
abstract class BaseCache extends \Cache
{
    /** @var static Instance. */
    protected static $instance;

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
     * Returns an instance of FileCache system.
     *
     * @return static The instance.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            $cacheSystem = _PS_CACHING_SYSTEM_;
            static::$instance = new $cacheSystem();
        }

        return static::$instance;
    }
}