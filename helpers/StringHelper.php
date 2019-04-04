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
 * @version 0.4.0
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

    /**
     * Purifies an HTML string.
     *
     * @param string $string The source string with HTML markup.
     *
     * @return string The text without HTML markup.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function purifyHTML($string)
    {
        $string = \Tools::purifyHTML($string);                       // HTML may not be valid, which is why strip_tags will not clear them correctly.
        $string = preg_replace('/&#?[a-z0-9]{2,8};/i', '', $string); // HTML purifier converts unpaired <> in HTML entities, but does not clean them.
        $string = strip_tags($string);                               // Now we remove all the markup, leaving only the text.
        $string = trim($string);                                     // Additionally, remove spaces.

        return $string;
    }

    /**
     * Converts a given string to the case like in a sentence.
     *
     * @param string $string The source string.
     *
     * @return string
     *
     * @see \Tools::ucfirst() Converts only the first character of a first word to uppercase.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function sentencenize($string)
    {
        $string = trim($string); // A correct sentence is not starts and ends with a space.
        $string = mb_strtolower($string);
        $string = \Tools::ucfirst($string);

        return $string;
    }
}