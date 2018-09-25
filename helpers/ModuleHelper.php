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

namespace zapalm\prestashopHelpers\helpers;

/**
 * Module helper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ModuleHelper
{
    /**
     * Returns an installed version of a module.
     *
     * @param int $idModule The module ID.
     *
     * @return string|null The installed version of the module or null, if the module isn't installed.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getInstalledVersion($idModule) {
        $version = \Db::getInstance()->getValue((new \DbQuery())
            ->select('version')
            ->from('module')
            ->where('id_module = ' . (int)$idModule)
        );

        if (false === is_string($version)) {
            return null;
        }

        return $version;
    }
}