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
 * Date helper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class DateHelper {

    /** Empty Date/Time. */
    const EMPTY_DATETIME = '0000-00-00 00:00:00';

    /** Beginning of the UNIX epoch. */
    const EPOCH_UNIX = '1970-01-01 00:00:00';

    /** Date/Time format by default. */
    const FORMAT_DATETIME_DEFAULT = 'Y-m-d H:i:s';

    /** Seconds in a hour. */
    const SEC_IN_HOUR = 3600;

    /** Seconds in a day. */
    const SEC_IN_DAY = 86400;

    /** Seconds in a week. */
    const SEC_IN_WEEK = 604800;

    /** Seconds in a month. */
    const SEC_IN_MONTH = 2419200;

    /** Seconds in a year. */
    const SEC_IN_YEAR = 31536000;
}