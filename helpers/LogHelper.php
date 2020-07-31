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
 * Log helper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class LogHelper
{
    /**
     * Logs a message with the given level and category.
     *
     * Works in PrestaShop 1.5 and greater.
     *
     * For example, how to use in a module:
     * ~~~
     * public function example() {
     *     $this->log('An error occupied.');
     * }
     * public function log($messages, $level = AbstractLogger::WARNING) {
     *     LogHelper::log($messages, $level, $this->l('A module category example'), $this->id);
     * }
     * ~~~
     *
     * @param string|string[] $messages     The message or messages to be logged.
     * @param int             $level        The level of the message.
     * @param string          $categoryName The category name. For example, the module title. Note the name will be validated by {@see Validate::isName()}, i.e. you can mostly use only letters (you can't use numbers and special symbols).
     * @param int             $categoryId   The category ID. For example, the module ID.
     *
     * @throws \UnexpectedValueException
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function log($messages, $level = \AbstractLogger::WARNING, $categoryName = 'Application', $categoryId = 1) {
        if (version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
            // In PrestaShop 1.4 there is an autoload problem, so sometimes AbstractLogger class not loaded
            // by PrestaShop autoloader and this issue not solves by this method.
            // In PrestaShop 1.3 and below the logger is not exists.
            return;
        } elseif (version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
            $loggerClass = \Logger::class;
        } else {
            $loggerClass = \PrestaShopLogger::class;
        }

        if (false === in_array($level, array(
                \AbstractLogger::DEBUG,
                \AbstractLogger::INFO,
                \AbstractLogger::WARNING,
                \AbstractLogger::ERROR,
            ))) {
            throw new \UnexpectedValueException();
        }

        if (false === is_array($messages)) {
            $messages = array($messages);
        }

        foreach ($messages as $message) {
            $message = str_replace(array("\n", "\r"), ' ', $message);
            $message = strip_tags($message);

            $loggerClass::addLog( /** @var \PrestaShopLogger|\Logger $loggerClass */
                $message,
                $level,
                null,
                $categoryName,
                $categoryId,
                true
            );
        }
    }
}