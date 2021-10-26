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

namespace zapalm\prestashopHelpers\components\qualityService;

use Configuration;
use Context;
use zapalm\prestashopHelpers\helpers\UrlHelper;

/**
 * Quality service ticket.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class QualityServiceTicket
{
    /** The operation: installation */
    const OPERATION_INSTALLATION = 'installation';
    /** The operation: uninstallation */
    const OPERATION_UNINSTALLATION = 'uninstallation';

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

    /** @var int The internal product ID in the quality service. */
    public $productId;

    /** @var string The symbolic name of a product. */
    public $productSymbolicName;

    /** @var string The version of a product. */
    public $productVersion;

    /** @var string The site domain. */
    public $shopDomain;

    /** @var string Public e-mail from a shop's contacts. */
    public $shopEmail;

    /** @var string The ISO-code of language. */
    public $languageIsoCode;

    /** @var string The version of PrestaShop. */
    public $prestashopVersion;

    /** @var string The version of ThirtyBees. */
    public $thirtybeesVersion;

    /** @var string The version of PHP. */
    public $phpVersion;

    /** @var string The version of IonCube. */
    public $ioncubeVersion;

    /**
     * Constructor.
     *
     * @param int $productId The internal product ID in the quality service.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function __construct($productId)
    {
        $this->productId         = (int)$productId;
        $this->prestashopVersion = _PS_VERSION_;
        $this->thirtybeesVersion = (defined('_TB_VERSION_') ? _TB_VERSION_ : '');
        $this->shopDomain        = UrlHelper::getShopDomain();
        $this->phpVersion        = PHP_VERSION;
        $this->languageIsoCode   = Context::getContext()->language->iso_code;
        $this->ioncubeVersion    = (function_exists('ioncube_loader_iversion') ? ioncube_loader_iversion() : '');

        // This public e-mail from a shop's contacts can be used by a developer to send only an urgent information about
        // security issue of a module!
        $this->shopEmail = Configuration::get('PS_SHOP_EMAIL');
    }
}