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
     * Works in PrestaShop 1.6 and greater.
     *
     * For example, how to use in a module:
     * ~~~
     * public function example() {
     *     $this->log('An error occupied.');
     * }
     * public function log($messages, $level = AbstractLogger::WARNING) {
     *     LogHelper::log($messages, $level, $this->displayName, $this->id);
     * }
     * ~~~
     *
     * @param string|string[] $messages     The message or messages to be logged.
     * @param int             $level        The level of the message.
     * @param string          $categoryName The category name. For example, the module title.
     * @param int             $categoryId   The category ID. For example, the module ID.
     *
     * @throws \UnexpectedValueException
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function log($messages, $level = \AbstractLogger::WARNING, $categoryName = 'Application', $categoryId = 1) {
        if (version_compare(_PS_VERSION_, '1.6', '<')) {
            return;
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

            \PrestaShopLogger::addLog(
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