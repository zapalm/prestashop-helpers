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
 * Base front controller for a module.
 *
 * It has the base methods for all child controllers.
 * Action methods should be named with prefix `action`.
 *
 * Example, how to use:
 * ~~~
 * class UserModuleFrontController extends BaseModuleFrontController {
 *     protected function actionIndex() {
 *         $this->setTemplate('user.tpl');
 *     }
 * }
 * // The output result is the template rendering result.
 * ~~~
 *
 * @property-read \Context $context Current context.
 * @property-read \Module  $module  Current module.
 *
 * @version 0.4.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class BaseModuleFrontController extends \ModuleFrontController
{
    /**
     * @inheritdoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function initContent() {
        // Did not called the parent for Ajax because it has unwanted assignations.
        if (false === $this->ajax) {
            parent::initContent();
        }

        $action = trim(\Tools::getValue('action'));
        if ('' !== $action) {
            $action = 'action' . $action;
            if (method_exists($this, $action)) {
                $this->$action();
            }
        }
    }

    /**
     * @inheritdoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setMedia() {
        // Did not called the parent for Ajax because it has unwanted assignations.
        if (false === $this->ajax) {
            parent::setMedia();
        }
    }

    /**
     * Sets a template for a page.
     *
     * @param string      $template The template filename.
     * @param array       $params   The template params (only for PrestaShop 1.7).
     * @param string|null $locale   The template locale (only for PrestaShop 1.7).
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setTemplate($template, $params = [], $locale = null)
    {
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $template = $this->module->getFrontTemplatePath($template);
            parent::setTemplate($template, $params, $locale);
        } else {
            parent::setTemplate($template);
        }
    }

    /**
     * Returns a translation for a given text.
     *
     * All parameters except `$text` and `$fileName` are unused and these are presents only for the compatibility.
     *
     * @param string      $text     The input text to translate.
     * @param string|bool $fileName The file name, containing the text to translate (or false to determine the file automatically).
     *
     * @return string The translation for a given text or the same text if there is no translation for it.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function l($text, $fileName = false, $class = null, $addslashes = false, $htmlentities = true)
    {
        if (false === $fileName) {
            if (null === $this->php_self) {
                $fileName = str_replace(strtolower(\ModuleFrontController::class), '', strtolower(static::class));
                $fileName = str_replace(strtolower($this->module->name), '', $fileName);
            } else {
                $fileName = strtolower($this->php_self);
            }
        }

        return $this->module->l($text, $fileName);
    }
}