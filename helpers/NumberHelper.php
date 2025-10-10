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
}