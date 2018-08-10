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
 * Ajax response.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class AjaxResponse
{
    /** @var bool Whether the result is success. */
    public $result = false;

    /** @var mixed A result data. */
    public $data;

    /** @var string A result data in HTML format. */
    public $html = '';

    /** @var string A message for a user. */
    public $message = '';

    /** @var string[] Error list. */
    public $errors = [];
}