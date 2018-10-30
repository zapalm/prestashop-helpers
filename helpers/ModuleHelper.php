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
 * @version 0.3.0
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

    /**
     * Returns an instance of a module by given directory path.
     *
     * @param string $directoryPath The directory path, for example, __DIR__.
     *
     * @return \Module|bool The module instance or false if the module did't found by the path.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getInstanceByPath($directoryPath)
    {
        $modulePath = str_replace(realpath(_PS_MODULE_DIR_) . DIRECTORY_SEPARATOR, '', $directoryPath);
        $moduleName = strstr($modulePath, DIRECTORY_SEPARATOR, true);
        if (ValidateHelper::isModuleName($moduleName)) {
            return \Module::getInstanceByName($moduleName);
        }

        return false;
    }

    /**
     * Uninstalls a module's tabs of the back-office menu.
     *
     * @param string $moduleName The module name.
     *
     * @return bool Whether the uninstall is success.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function uninstallTabs($moduleName) {
        foreach (\Tab::getCollectionFromModule($moduleName) as $tab) {
            if (false === $tab->delete()) {
                return false;
            }
        }

        return true;
    }
}