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
 * @version 0.1.0
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
}