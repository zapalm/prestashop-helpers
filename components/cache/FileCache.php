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
 * File cache system.
 *
 * @version 0.3.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class FileCache extends CacheFs
{
    /** @var static Instance. */
    protected static $instance;

    /**
     * Protected cloner.
     *
     * Maksim T. <zapalm@yandex.com>
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
     * Maksim T. <zapalm@yandex.com>
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Returns a key name for a data caching.
     *
     * @param string $method  The method name, i.e. __METHOD__.
     * @param array  $params  Parameters for the key name.
     * @param int    $version The parameter for the cache versioning.
     *
     * @return string
     *
     * @see BaseCache::getKeyName() The base method, but this one is duplication because of the problem of the overriding core classes.
     *
     * Maksim T. <zapalm@yandex.com>
     */
    public function getKeyName($method, array $params = [], $version = 1)
    {
        return $method . '::' . serialize($params) . '::v' . $version;
    }
}