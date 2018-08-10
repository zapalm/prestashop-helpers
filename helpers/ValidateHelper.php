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
 * Validate helper.
 *
 * @version 0.2.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ValidateHelper extends \Validate
{
    /**
     * Returns whether a value is correct identifier.
     *
     * @param string|int $value The value to check.
     *
     * @return bool
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isId($value) {
        return (parent::isUnsignedInt($value) && (int)$value > 0);
    }

    /**
     * Returns whether a value is correct UUID identifier.
     *
     * @param string $value The value to check.
     *
     * @return bool
     *
     * @link https://en.wikipedia.org/wiki/Universally_unique_identifier
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isUuid($value) {
        return (1 === preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $value));
    }
}