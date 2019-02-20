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

use zapalm\prestashopHelpers\helpers\UrlHelper;

/**
 * Quality service component.
 *
 * @version 0.5.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class QualityService
{
    /** @var \Module The module. */
    protected $module;

    /** @var string The quality service URL. */
    protected $serviceUrl;

    /** @var bool Whether the paid support is included to the ticket. */
    protected $isPaidSupportIncluded;

    /** @var array The support ticket data. */
    protected $ticketData;

    /**
     * Constructor.
     *
     * @param \Module $module                The module.
     * @param bool    $isPaidSupportIncluded Whether the paid support is included to the ticket.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function __construct(\Module $module, $isPaidSupportIncluded)
    {
        $this->module                = $module;
        $this->serviceUrl            = 'https://prestashop.modulez.ru/scripts/quality-service/index.php';
        $this->isPaidSupportIncluded = $isPaidSupportIncluded;
        $this->ticketData            = array();
    }

    /**
     * Registers a module installation in the quality service.
     *
     * @param bool        $isSuccess Whether the installation was successfully done.
     * @param string|null $message   The message (about an error or an informational message).
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function registerModule($isSuccess, $message = null)
    {
        $data            = $this->getInstallationData();
        $data->operation = $data::OPERATION_INSTALLATION;
        $data->status    = ($isSuccess ? $data::STATUS_SUCCESS : $data::STATUS_ERROR);
        $data->message   = $message;

        $this->ticketData['data'] = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        @file_get_contents($this->serviceUrl . '?' . http_build_query($this->ticketData));
    }

    /**
     * Sets a quality service URL.
     *
     * @param string $serviceUrl The quality service URL.
     *
     * @return self
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setServiceUrl($serviceUrl)
    {
        $this->serviceUrl = $serviceUrl;

        return $this;
    }

    /**
     * Sets a support ticket data.
     *
     * @param array $data The support ticket data.
     *
     * @return self
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setTicketData(array $data) {
        $this->ticketData = $data;

        return $this;
    }

    /**
     * Returns the installation data of a module.
     *
     * @return QualityServiceRequestData
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function getInstallationData()
    {
        $data = new QualityServiceRequestData();

        $data->prestashopVersion = _PS_VERSION_;
        $data->thirtybeesVersion = (defined('_TB_VERSION_') ? _TB_VERSION_ : null);
        $data->shopDomain        = UrlHelper::getShopDomain();

        if ($this->isPaidSupportIncluded && (null !== $data->thirtybeesVersion || version_compare($data->prestashopVersion, '1.5.0.1', '>='))) {
            $data->languageIsoCode    = \Context::getContext()->language->iso_code;
            $data->shopEmail          = \Configuration::get('PS_SHOP_EMAIL');
            $data->administratorEmail = \Context::getContext()->employee->email;
        }

        return $data;
    }
}