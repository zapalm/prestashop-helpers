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

namespace zapalm\prestashopHelpers\components\qualityService;

/**
 * Quality service request data.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class QualityServiceRequestData
{
    /** The operation: installation */
    const OPERATION_INSTALLATION = 'installation';

    /** The status of an operation: success. */
    const STATUS_SUCCESS = 'success';
    /** The status of an operation: warning. */
    const STATUS_WARNING = 'warning';
    /** The status of an operation: error. */
    const STATUS_ERROR   = 'error';

    /** @var string The operation. */
    public $operation;

    /** @var string The status of an operation. */
    public $status;

    /** @var string The message (about an error or an informational message). */
    public $message;

    /** @var string The site domain. */
    public $shopDomain;

    /** @var string The e-mail of a shop. */
    public $shopEmail;

    /** @var string The e-mail of an administrator. */
    public $administratorEmail;

    /** @var string The ISO-code of language. */
    public $languageIsoCode;

    /** @var string The version of PrestaShop. */
    public $prestashopVersion;

    /** @var string The version of ThirtyBees. */
    public $thirtybeesVersion;
}