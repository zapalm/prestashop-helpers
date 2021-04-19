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

use Context;
use RuntimeException;

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
     * It aimed to translate attributes of classes or other literals in any classes, scripts and Smarty templates.
     * It will create a translation file, for example, in `/translations/[ISO code]/sentences.php` and after this you can translate literals manually.
     * For convenient use of this method, make a wrapper.
     *
     * @param string      $sentence              The sentence.
     * @param string      $sourcePath            The file path (or class path) with that sentence.
     * @param string|null $languageIsoCode       The language ISO code to translate into or null to get it automatically from the context.
     * @param string      $translationsDirectory The directory for translation files. Defaults: `/translations`.
     * @param bool        $combineTranslations   Whether to combine all translations into one file.
     * @param bool        $modifyStorage         Whether to modify the storage file with translations.
     *
     * @return string The translated sentence or the same sentence if it was not translated before.
     *
     * @throws RuntimeException If a directory for translation files does not exists and can not be created. If The file path (class path) does not exists.
     *
     * @see \ObjectModel::displayFieldName() To translate an attribute of an ObjectModel subclass.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function translate($sentence, $sourcePath, $languageIsoCode = null, $translationsDirectory = _PS_TRANSLATIONS_DIR_, $combineTranslations = false, $modifyStorage = true)
    {
        if (file_exists($sourcePath)) {
            $index = str_replace(realpath(_PS_ROOT_DIR_) . DIRECTORY_SEPARATOR, '', realpath($sourcePath)); // Getting a relative path from a site root
            $index = str_replace('/', '\\', $index); // Making the same slash as for a namespace
        } elseif (class_exists($sourcePath, false)) {
            $index = $sourcePath;
        } else {
            throw new RuntimeException('The file path (class path) does not exists: ' . $sourcePath);
        }

        if (null === $languageIsoCode) {
            $languageIsoCode = Context::getContext()->language->iso_code;
        } else {
            $languageIsoCode = strtolower($languageIsoCode);
        }

        $vocabularyDirectory = rtrim($translationsDirectory, '/\\');
        if (false === $combineTranslations) {
            $vocabularyDirectory .= DIRECTORY_SEPARATOR . $languageIsoCode;
        }

        if (false === file_exists($vocabularyDirectory)) {
            if (false === mkdir($vocabularyDirectory, 0777, true)) {
                throw new RuntimeException('Can not create the directory for translation files: ' . $vocabularyDirectory);
            }
        }

        $vocabularyFilePath = $vocabularyDirectory . DIRECTORY_SEPARATOR . 'sentences.php';
        if (file_exists($vocabularyFilePath)) {
            $vocabulary = $vocabularyOld = require $vocabularyFilePath;

            if ($combineTranslations) {
                if (false === empty($vocabulary[$index][$sentence][$languageIsoCode])) {
                    return $vocabulary[$index][$sentence][$languageIsoCode];
                }
            } else {
                if (false === empty($vocabulary[$index][$sentence])) {
                    return $vocabulary[$index][$sentence];
                }
            }
        } else {
            $vocabulary = $vocabularyOld = [];
        }

        if ($combineTranslations) {
            $vocabulary[$index][$sentence][$languageIsoCode] = '';
        } else {
            $vocabulary[$index][$sentence] = '';
        }

        if ($modifyStorage && $vocabulary !== $vocabularyOld) {
            file_put_contents($vocabularyFilePath, '<?php return ' . var_export($vocabulary, true) . ';');
        }

        return $sentence;
    }
}