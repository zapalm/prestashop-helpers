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

use Module;
use Tools;
use zapalm\prestashopHelpers\helpers\ObjectHelper;

/**
 * Quality service component.
 *
 * @version 0.4.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class QualityServiceClient
{
    /** @var string The quality service URL. */
    protected $serviceUrl;

    /** @var QualityServiceTicket The support ticket data. */
    protected $ticket;

    /**
     * Constructor.
     *
     * @param int $productId The internal product ID in the quality service.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function __construct($productId)
    {
        $this->ticket     = new QualityServiceTicket($productId);
        $this->serviceUrl = 'https://prestashop.modulez.ru/scripts/quality-service/index.php';
    }

    /**
     * Registers a module installation in the quality service.
     *
     * @param Module $module The module.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function installModule(Module $module)
    {
        $message   = implode(' ', $this->getErrors($module));
        $isSuccess = ('' === $message);

        $ticket                      = $this->ticket;
        $ticket->productSymbolicName = $module->name;
        $ticket->productVersion      = $module->version;
        $ticket->operation           = $ticket::OPERATION_INSTALLATION;
        $ticket->status              = ($isSuccess ? $ticket::STATUS_SUCCESS : $ticket::STATUS_ERROR);
        $ticket->message             = $message;

        $requestParams = ObjectHelper::convertToArray($this->ticket);
        $requestUrl    = $this->serviceUrl . '?' . http_build_query(['data' => json_encode($requestParams, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)]);
        Tools::file_get_contents($requestUrl, false, null, 5, true);
    }

    /**
     * Registers a module uninstallation in the quality service.
     *
     * @param Module $module The module.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function uninstallModule(Module $module)
    {
        $message   = implode(' ', $this->getErrors($module));
        $isSuccess = ('' === $message);

        $ticket                      = $this->ticket;
        $ticket->productSymbolicName = $module->name;
        $ticket->productVersion      = $module->version;
        $ticket->operation           = $ticket::OPERATION_UNINSTALLATION;
        $ticket->status              = ($isSuccess ? $ticket::STATUS_SUCCESS : $ticket::STATUS_ERROR);
        $ticket->message             = $message;

        $requestParams = ObjectHelper::convertToArray($this->ticket);
        $requestUrl    = $this->serviceUrl . '?' . http_build_query(['data' => json_encode($requestParams, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)]);
        Tools::file_get_contents($requestUrl, false, null, 5, true);
    }

    /**
     * Returns errors list of a module.
     *
     * @param Module $module The module.
     *
     * @return string[]
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function getErrors(Module $module)
    {
        $errors = [];

        foreach ($module->getErrors() as $error) {
            $error = stripslashes($error);
            $error = strip_tags($error);
            $error = rtrim($error, '. ') . '.';

            $errors[] = $error;
        }

        return $errors;
    }
}