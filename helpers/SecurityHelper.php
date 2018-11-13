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
 * Security helper.
 *
 * @version 0.2.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class SecurityHelper
{
    /** Password generation method: a password contains numeric values. */
    const PASSWORD_METHOD_NUMERIC      = 'NUMERIC';
    /** Password generation method: a password contains letters and numeric values. */
    const PASSWORD_METHOD_ALPHANUMERIC = 'ALPHANUMERIC';
    /** Password generation method: a password contains random symbols. */
    const PASSWORD_METHOD_RANDOM       = 'RANDOM';

    /** Password length: minimal. The same as {@see ValidateHelper::PASSWORD_LENGTH}. */
    const PASSWORD_LENGTH_MIN    = 5;
    /** Password length: normal */
    const PASSWORD_LENGTH_NORMAL = 6;
    /** Password length: strong. The same as {@see ValidateHelper::ADMIN_PASSWORD_LENGTH}. */
    const PASSWORD_LENGTH_STRONG = 8;

    /**
     * Generates a strong password for an employee or a customer.
     *
     * @return string
     *
     * @see \Tools::passwdGen() The base method.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function generateStrongPassword()
    {
        do {
            $password = \Tools::passwdGen(static::PASSWORD_LENGTH_STRONG, static::PASSWORD_METHOD_ALPHANUMERIC);
        } while (false === static::isStrongPassword($password));

        return $password;
    }

    /**
     * Checks a password strength.
     *
     * A strong password contains:
     *   - at least 6 symbols
     *   - at least one digit
     *   - at least one upper case letter
     *
     * @param string $password The password to check.
     *
     * @return bool Whether the password is strong.
     *
     * @see ValidateHelper::isPasswdAdmin() Checks only for a minimum length of a password (i.e., the method is not recommended).
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isStrongPassword($password)
    {
        if (mb_strlen($password) < static::PASSWORD_LENGTH_NORMAL) {
            return false;
        }

        // Count how many lowercase, uppercase, and digits are in the password
        $upperCaseLetters = 0;
        $lowerCaseLetters = 0;
        $numbers          = 0;
        $otherSymbols     = 0;
        for ($i = 0, $passwordLength = mb_strlen($password); $i < $passwordLength; $i++) {
            $symbol = mb_substr($password, $i, 1);
            if (preg_match('/^[[:upper:]]$/', $symbol)) {
                $upperCaseLetters++;
            } elseif (preg_match('/^[[:lower:]]$/', $symbol)) {
                $lowerCaseLetters++;
            } elseif (preg_match('/^[[:digit:]]$/', $symbol)) {
                $numbers++;
            } else {
                $otherSymbols++;
            }
        }

        if (0 === $upperCaseLetters || 0 === $lowerCaseLetters || 0 === $numbers) {
            return false;
        }

        return true;
    }
}