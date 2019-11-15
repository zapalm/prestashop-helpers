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
 * Cache provider.
 *
 * @version 0.2.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class CacheProvider
{
    /**
     * Returns an instance of a system wide cache system or FileCache system if the first one is disabled.
     *
     * @return BaseCache|FileCache Cache system.
     *
     * Maksim T. <zapalm@yandex.com>
     */
    public static function getInstance()
    {
        if (true === (bool)_PS_CACHE_ENABLED_) {
            return BaseCache::getInstance();
        } else {
            return FileCache::getInstance();
        }
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
        return $method . '::' . serialize($params) . '::v' . $version;
    }
}