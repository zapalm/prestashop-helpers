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

namespace zapalm\prestashopHelpers\controllers;

/**
 * Ajax front controller for a module.
 *
 * It's more simple to use and works faster.
 * Action methods should be named with prefix `action`.
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
 * @version 0.2.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class AjaxModuleFrontController extends BaseModuleFrontController {

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
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function initContent() {
        parent::initContent();

        header('Content-Type: application/json');
        exit(json_encode($this->ajaxResponse));
    }
}