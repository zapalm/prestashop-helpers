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
 * Backend helper.
 *
 * @version 0.4.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class BackendHelper
{
    /** Tab parent ID: unlinked, i.e. without linking to a parent tab of the menu */
    const TAB_PARENT_ID_UNLINKED = -1;
    /** Tab parent ID: the root tab of the menu */
    const TAB_PARENT_ID_ROOT     = 0;

    /**
     * Installs a tab for the back-office menu.
     *
     * @param string               $moduleName  The module name or empty string if the tab not for a module.
     * @param string               $tabClass    The class name of the tab.
     * @param int|null             $tabParentId The ID of the parent tab. If null, will be linked to the root tab of the menu.
     * @param string|string[]|null $tabTitle    The title of the tab in default language or the array of tab titles for each language or null to generate the title.
     *
     * @return \Tab The installed tab.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function installTab($moduleName, $tabClass, $tabParentId = null, $tabTitle = null)
    {
        if (null === $tabParentId) {
            $tabParentId = static::TAB_PARENT_ID_ROOT;
        }

        if (ValidateHelper::isEmpty($tabTitle)) {
            $tabTitle = basename($tabClass);
            $tabTitle = substr($tabTitle, strlen('Admin'), strlen($tabTitle));
            $tabTitle = StringHelper::camel2words($tabTitle, false);
            $tabTitle = ucfirst($tabTitle);
        }

        $languageIsoCodeDefault = \Language::getIsoById(\Configuration::get('PS_LANG_DEFAULT'));

        if (false === is_array($tabTitle)) {
            $tabTitle = [$languageIsoCodeDefault => $tabTitle];
        }

        if (false === isset($tabTitle[$languageIsoCodeDefault])) {
            $tabTitle[$languageIsoCodeDefault] = reset($tabTitle);
        }

        $tabTitle = array_combine(array_map('strtolower', array_keys($tabTitle)), $tabTitle);

        $tab = \Tab::getInstanceFromClassName($tabClass);
        $tab->id_parent  = $tabParentId;
        $tab->class_name = $tabClass;
        $tab->module     = $moduleName;
        $tab->active     = true;

        foreach (\Language::getLanguages(false) as $language) {
            $tab->name[$language['id_lang']] = (isset($tabTitle[$language['iso_code']])
                ? $tabTitle[$language['iso_code']]
                : $tabTitle[$languageIsoCodeDefault]
            );
        }

        $tab->save();

        return $tab;
    }

    /**
     * Uninstalls a tab of the back-office menu.
     *
     * @param string $tabClass The class name of the tab.
     *
     * @return bool Whether the uninstall is success.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function uninstallTab($tabClass)
    {
        $tab = \Tab::getInstanceFromClassName($tabClass);
        if (ValidateHelper::isLoadedObject($tab)) {
            return $tab->delete();
        }

        return true;
    }

    /**
     * Installs a hook.
     *
     * @param string      $name        The hook name.
     * @param string|null $title       The title or null to generate automatically.
     * @param string|null $description The description (optional).
     *
     * @return bool Whether the installation is success.
     *
     * @throws \LogicException If the hook name is invalid.
     *
     * @see \Module::registerHook() To register the hook after the installation.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function installHook($name, $title = null, $description = null)
    {
        if (0 === strpos($name, 'action')) {
            $prefixLength = strlen('action');
            $isPositional = false;
        } elseif (0 === strpos($name, 'display')) {
            $prefixLength = strlen('display');
            $isPositional = true;
        } else {
            throw new \LogicException('Invalid hook name: there is no prefix (action or display).');
        }

        if (null === $title) {
            $title = substr($name, $prefixLength, strlen($name));
            $title = StringHelper::camel2words($title, false);
            $title = ucfirst($title);
        }

        $hook = new \Hook();

        $hook->name        = $name;
        $hook->title       = $title;
        $hook->description = $description;
        $hook->position    = $isPositional;
        $hook->live_edit   = $isPositional;

        return (bool)$hook->save();
    }

    /**
     * Uninstalls a hook.
     *
     * @param string $name The hook name.
     *
     * @return bool Whether the uninstallation is success.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function uninstallHook($name)
    {
        $id = \Hook::getIdByName($name);
        if (false === $id) {
            return true;
        }

        $hook = new \Hook($id);

        return (bool)$hook->delete();
    }
}