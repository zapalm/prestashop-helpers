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
 * Diagnostic helper.
 *
 * @version 0.4.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class DiagnosticHelper
{
    /**
     * Checks if the given class is overridden.
     *
     * @param string $className The class name to check.
     *
     * @return bool Whether the class is overridden.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isClassOverridden($className)
    {
        $files = FileHelper::findFiles(_PS_OVERRIDE_DIR_ . '*.php');
        foreach ($files as $file) {
            if (basename($file, '.php') === $className) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the given class is exists in the PrestaShop class index (i.e., the class path is cached).
     *
     * @param string $className The class name to check.
     *
     * @return bool Whether the class path is cached.
     *
     * @see \PrestaShopAutoload::INDEX_FILE
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isClassPathCached($className)
    {
        return isset(\PrestaShopAutoload::getInstance()->index[$className]);
    }

    /**
     * Regenerates PrestaShop class index.
     *
     * @see isClassPathCached()
     * @see \PrestaShopAutoload::INDEX_FILE
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function regenerateClassIndex()
    {
        \PrestaShopAutoload::getInstance()->generateIndex();
    }

    /**
     * Checks if the given method is overridden.
     *
     * @param string $className  The class of the method to check.
     * @param string $methodName The method name to check.
     *
     * @return bool Whether the method is overridden.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isMethodOverridden($className, $methodName)
    {
        if (static::isClassOverridden($className)) {
            $reflectionClass = new \ReflectionClass($className);
            if ($reflectionClass->hasMethod($methodName)) {
                $reflectionMethod = new \ReflectionMethod($className, $methodName);

                return ($reflectionMethod->getDeclaringClass()->getName() === $className);
            }
        }

        return false;
    }
}