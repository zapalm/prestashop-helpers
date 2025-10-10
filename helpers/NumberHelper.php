<?php
/**
 * Helper classes for PrestaShop CMS.
 *
 * @author    Maksim T. <zapalm@yandex.com>
 * @copyright 2018 Maksim T.
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/zapalm/prestashop-helpers GitHub
 * @link      https://prestashop.modulez.ru/en/tools-scripts/53-helper-classes-for-prestashop.html Homepage
 */

namespace zapalm\prestashopHelpers\helpers;

use Context;
use Tools;

/**
 * Number helper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class NumberHelper
{
    /**
     * Format a number as a price.
     *
     * @param int|float|string $number  The number.
     * @param Context|null     $context The context.
     *
     * @return string
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function formatPrice($number, Context $context = null)
    {
        $context = (null !== $context ? $context : Context::getContext());

        if (version_compare(_PS_VERSION_, '9.0', '>=')) {
            return Tools::getContextLocale($context)->formatPrice($number, $context->currency->iso_code);
        }

        return Tools::displayPrice($number, $context->currency, false, $context);
    }

    /**
     * Format a number.
     *
     * This method is needed because {@see Tools::displayNumber()} method removes the fractional part in versions before
     * PS 1.7, and in PS 1.7 versions there is another bug - the incorrect number of decimal places (three characters instead
     * of two were noticed in PS 1.7.6.0).
     *
     * @param int|float|string $number  The number.
     * @param Context|null     $context The context.
     *
     * @return string
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function formatNumber($number, Context $context = null)
    {
        // There is no normal solution for older versions where there is a bug in the Tools::displayNumber() method, so I
        // did it this way - it works in all supported PS versions.
        $context = (null !== $context ? $context : Context::getContext());
        $number  = self::formatPrice($number, $context);
        $number  = str_replace($context->currency->sign, '', $number);
        $number  = trim($number, ' ' . chr(194) . chr(160)); // Here we remove the whitespace characters at the edges (the non-breaking space has a sequence of bytes: 194, 160)

        return $number;
    }
}