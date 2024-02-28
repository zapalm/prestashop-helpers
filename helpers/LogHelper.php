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
     * For example, how to use in a module:
     * ~~~
     * public function example() {
     *     $this->log('An error occupied.');
     * }
     * public function log($messages, $level = AbstractLogger::WARNING) {
     *     LogHelper::log($messages, $level, $this->name, $this->id);
     * }
     * ~~~
     *
     * @param string|string[] $messages     The message or messages to be logged.
     * @param int             $level        The level of the message.
     * @param string          $categoryName The log category name. For example, a module technical name or some class name. In different PrestaShop versions a different validator is used (in PS 8 - isValidObjectClassName, in older versions - isName), i.e. you can mostly use only letters (you can't use numbers and special symbols).
     * @param int             $categoryId   The log category ID. For example, a module ID or some object ID.
     *
     * @throws \UnexpectedValueException
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function log($messages, $level = \AbstractLogger::WARNING, $categoryName = 'Application', $categoryId = 1) {
        if (version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
            $loggerClass = \Logger::class;
        } else {
            $loggerClass = \PrestaShopLogger::class;
        } /** @var string|\PrestaShopLogger|\Logger $loggerClass */

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

            $loggerClass::addLog(
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