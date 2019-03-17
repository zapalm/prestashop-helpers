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
 * Helper to work with .htaccess file.
 *
 * @version 0.4.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class HtaccessHelper
{
    /** @var string|null The error of a last operation. */
    private static $error;

    /**
     * Removes rules by a given tag.
     *
     * @param string $tagName The tag name of rules group to be deleted.
     *
     * @return bool
     *
     * @see getError() To get an error when the method returns false.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function removeRulesByTag($tagName)
    {
        return static::updateFile($tagName, [], true);
    }

    /**
     * Adds rules.
     *
     * @param string   $tagName   The tag name for rules grouping.
     * @param string[] $rulesList The list of rules to add.
     *
     * @return bool
     *
     * @see getError() To get an error when the method returns false.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function addRules($tagName, array $rulesList)
    {
        return static::updateFile($tagName, $rulesList, false);
    }

    /**
     * Updates the .htaccess file.
     *
     * Use `SHOP_URL` string for generating URLs for each configured shop, for example:
     * ```
     * SHOP_URL/index.php?fc=module&module=example
     * ```
     *
     * @param string   $tagName     The tag name for rules grouping.
     * @param string[] $rulesList   The list of rules to add.
     * @param bool     $removeRules Whether rules should be removed instead of adding.
     *
     * @return bool
     *
     * @see getError() To get an error when the method returns false.
     *
     * @throws \LogicException
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected static function updateFile($tagName, array $rulesList, $removeRules)
    {
        // Clear the last error.
        static::$error = null;

        $htaccessPath = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . '.htaccess';
        if (false === is_writable($htaccessPath)) {
            static::$error = 'The file is not writable: ' . $htaccessPath;

            return false;
        }

        if (false === $removeRules && [] === $rulesList) {
            throw new \LogicException('Incorrect method call.');
        }

        $startTag = '#start_' . $tagName;
        $endTag   = '#end_' . $tagName;

        $existingRules = file_get_contents($htaccessPath);
        if (false !== strpos($existingRules, $startTag)) {
            $matches = array();
            preg_match_all('/' . $startTag . '(.*)' . $endTag . '\\n\\n/Usi', $existingRules, $matches);
            if (false === empty($matches)) {
                $existingRules = str_replace($matches[0], '', $existingRules);
            }
        }

        if ($removeRules) {
            $result = file_put_contents($htaccessPath, $existingRules);
            if (false === $result) {
                static::$error = 'Can not write to .htaccess file.';
            }

            return $result;
        }

        $newRules = $startTag . ' - do not remove these comments (these are search tags)' . "\n";
        foreach (ArrayHelper::getColumn(\ShopUrl::getShopUrls()->getResults(), 'physical_uri', false, true) as $shopUrl) {
            foreach ($rulesList as $rule) {
                $newRules .= str_replace('SHOP_URL', rtrim($shopUrl, '/'), $rule) . "\n";
            }
        }
        $newRules .= $endTag . "\n\n";

        $result = file_put_contents($htaccessPath, $newRules . $existingRules);
        if (false === $result) {
            static::$error = 'Can not write to .htaccess file.';
        }

        return $result;
    }

    /**
     * Returns an error of a last operation.
     *
     * @return string|null The error message or null if there was no an error.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getError()
    {
        return static::$error;
    }
}