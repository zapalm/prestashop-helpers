<?php
/**
 * Helper classes for PrestaShop CMS.
 *
 * @author    Maksim T. <zapalm@yandex.com>
 * @copyright 2018 Maksim T.
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/zapalm/prestashopHelpers GitHub
 * @link      https://prestashop.modulez.ru/en/contact-us Contact form
 */

namespace zapalm\prestashopHelpers\controllers;

/**
 * Ajax front controller for a module.
 *
 * It's more simple to use and works faster.
 * Action methods should be named with prefix "action".
 *
 * Example, how to use:
 * ~~~
 * class ExampleAjaxModuleFrontController extends AjaxModuleFrontController {
 *     protected function actionSave() {
 *         $this->ajaxResponse->result  = true;
 *         $this->ajaxResponse->message = 'Success!';
 *     }
 * }
 * // The output result is:
 * // {"result":true,"data":null,"html":"","message":"Success!","errors":[]}
 * ~~~
 *
 * @property-read \Context $context Current context.
 * @property-read \Module  $module  Current module.
 *
 * @version 0.3.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class AjaxModuleFrontController extends \ModuleFrontController {

    /** @var AjaxResponse Response object. */
    protected $ajaxResponse;

    /**
     * @inheritdoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function init() {
        $this->ajaxResponse = new AjaxResponse();
        $this->ajax         = true;
        $this->content_only = true;

        parent::init();
    }

    /**
     * @inheritdoc
     *
     * Did not called the parent because it has unwanted assignations for Ajax.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function initContent() {
        $action = trim(\Tools::getValue('action'));
        if ('' !== $action) {
            $action = 'action' . $action;
            if (method_exists($this, $action)) {
                $this->$action();

                header('Content-Type: application/json');
                exit(json_encode($this->ajaxResponse));
            }
        }
    }

    /**
     * @inheritdoc
     *
     * Did not called the parent because it has unwanted assignations for Ajax.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setMedia() {}
}