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
 * URL helper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class UrlHelper {

    /**
     * Returns an URL to the back-office (admin page).
     *
     * It's usable only in the context of the back-office.
     *
     * @return string The URL with trailing slash.
     *
     * @throws \LogicException If called not in the back-office context.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getAdminUrl() {
        if (false === defined('_PS_ADMIN_DIR_')) {
            throw new \LogicException();
        }

        return \Context::getContext()->shop->getBaseURL() . basename(_PS_ADMIN_DIR_) . '/';
    }
}