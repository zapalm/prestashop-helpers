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
 * Translate helper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class TranslateHelper
{
    /**
     * Translates a sentence.
     *
     * It aimed to translate attributes of classes or other literals in any classes.
     * It will create a translation file in /translations/[ISO code]/sentences.php and after this you can translate literals manually.
     *
     * @param string      $sentence        The sentence.
     * @param string      $class           The class.
     * @param string|null $languageIsoCode The language ISO code or null to get it automatically from the context.
     *
     * @return string The translated sentence or the same sentence if it was not translated before.
     *
     * @throws \ReflectionException If the class does not exist.
     *
     * @see \ObjectModel::displayFieldName() To translate an attribute of an ObjectModel subclass.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function translate($sentence, $class, $languageIsoCode = null)
    {
        if (null === $languageIsoCode) {
            $languageIsoCode = \Context::getContext()->language->iso_code;
        }

        $reflectionClass = new \ReflectionClass($class);
        $index           = $reflectionClass->getName();
        $vocabulary      = [];

        $vocabularyFilePath = _PS_TRANSLATIONS_DIR_ . $languageIsoCode . '/sentences.php';
        if (file_exists($vocabularyFilePath)) {
            $vocabulary = require $vocabularyFilePath;

            if (isset($vocabulary[$index][$sentence])) {
                return $vocabulary[$index][$sentence];
            }
        }

        $vocabulary[$index][$sentence] = $sentence;
        file_put_contents($vocabularyFilePath, '<?php return ' . var_export($vocabulary, true) . ';');

        return $sentence;
    }
}