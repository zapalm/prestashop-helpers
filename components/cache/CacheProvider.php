<?php
/**
 * Helper classes for PrestaShop CMS.
 *
 * @author    Maksim T. <zapalm@yandex.com>
 * @copyright 2018 Maksim T.
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/zapalm/prestashop-helpers GitHub
 * @link      https://prestashop.modulez.ru/en/tools-scripts/53-helper-classes-for-prestashop.html Homepage
 */

namespace zapalm\prestashopHelpers\components\cache;

use CacheFs;
use CacheMemcache;
use CacheMemcached;

/**
 * Cache provider.
 *
 * @version 0.2.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class CacheProvider
{
    /** Caching system: File cache (storage in a file system). */
    const SYSTEM_FILECACHE = FileCache::class;

    /** Caching system: Memcache. */
    const SYSTEM_MEMCACHE  = CacheMemcache::class;

    /** Caching system: Memcached. */
    const SYSTEM_MEMCACHED = CacheMemcached::class;

    /**
     * Returns an instance of a cache system.
     *
     * @param bool   $useSystemWideCaching     Whether to use system wide caching.
     * @param string $preferredSystemClassName The preferred caching system to use If the system wide caching system is not used (see constants). If the preferred system cannot be used then FileCache system will be used.
     *
     * @return BaseCache|CacheFs Cache system.
     *
     * Maksim T. <zapalm@yandex.com>
     */
    public static function getInstance($useSystemWideCaching = true, $preferredSystemClassName = self::SYSTEM_FILECACHE)
    {
        if ($useSystemWideCaching && true === (bool)_PS_CACHE_ENABLED_) {
            // Because CacheFs has protected constructor, so getInstance() method must be used.
            // In other case BaseCache::getInstance() will be used.
            if (version_compare(_PS_VERSION_, '1.7.0.0', '<') && CacheFs::class === _PS_CACHING_SYSTEM_) {
                /** @noinspection PhpIncompatibleReturnTypeInspection */
                return CacheFs::getInstance();
            }

            BaseCache::setCachingSystemClassName(_PS_CACHING_SYSTEM_);
        }

        if (false === $useSystemWideCaching && in_array($preferredSystemClassName, [self::SYSTEM_MEMCACHE, self::SYSTEM_MEMCACHED])) {
            BaseCache::setCachingSystemClassName($preferredSystemClassName);
        }

        if (null !== BaseCache::getCachingSystemClassName()) {
            return BaseCache::getInstance();
        }

        return FileCache::getInstance();
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
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getKeyName($method, array $params = [], $version = 1)
    {
        return $method . ':' . implode(':', $params) . ':v' . $version;
    }
}