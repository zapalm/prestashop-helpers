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
 * String helper.
 *
 * @version 0.2.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class StringHelper
{
    /**
     * Converts a CamelCase name into space-separated words.
     *
     * For example, `PostTag` will be converted to `Post Tag`.
     *
     * @param string $name       The string to be converted.
     * @param bool   $capitalize Whether to capitalize the first letter in each word.
     *
     * @return string Space-separated words.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function camel2words($name, $capitalize = true)
    {
        $words = preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name);
        $words = str_replace(['-', '_', '.'], ' ', $words);
        $words = trim($words);
        $words = strtolower($words);

        return ($capitalize ? ucwords($words) : $words);
    }

    /**
     * Converts a word into CamelCased.
     *
     * Converts a word like `send_email` to `SendEmail`.
     * It will remove non alphanumeric character from the word, so `who's online` will be converted to `WhoSOnline`.
     *
     * @param string $word The word to convert.
     *
     * @return string The CamelCased string.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function camelize($word)
    {
        return str_replace(' ', '', ucwords(preg_replace('/[^A-Za-z0-9]+/', ' ', $word)));
    }
}