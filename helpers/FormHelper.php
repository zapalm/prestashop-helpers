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
 * Form helper.
 *
 * @version 0.6.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class FormHelper extends \HelperForm
{
    /**
     * Generates breadcrumbs.
     *
     * For example,
     *
     * ~~~
     * $breadcrumbs = FormHelper::breadcrumbs([
     *     'Page'         => 'https://example.loc/page',
     *     'Sup page'     => 'https://example.loc/page/suppage',
     *     'Current page' => null, // A current page without URL to it.
     * ]);
     * Context::getContext()->smarty->assign('path', $breadcrumbs);
     * // The result is:
     * <a href="https://example.loc/page">Page</a><span class="navigation_page"> &gt; </span>
     * <a href="https://example.loc/page/suppage">Sup page</a><span class="navigation_page"> &gt; </span>
     * Current page
     * // After page rendering these breadcrumbs are looks like:
     * Home > Page > Sup page > Current page
     * ~~~
     *
     * @param array  $definition       The definition of breadcrumbs, i.e. the array of titles associated with URLs.
     * @param string $defaultSeparator The default separator for breadcrumbs.
     *
     * @return string The generated breadcrumbs.
     */
    public static function breadcrumbs(array $definition, $defaultSeparator = '>')
    {
        $result = [];
        foreach ($definition as $title => $url) {
            if (null === $url) {
                $result[] = static::encode($title);
            } else {
                $result[] = '<a href="' . static::encode($url) . '">' . static::encode($title) . '</a>';
            }
        }

        $separator = \Configuration::get('PS_NAVIGATION_PIPE', $defaultSeparator);
        $separator = '<span class="navigation_page"> ' . static::encode($separator) . ' </span>';

        return implode($separator, $result);
    }

    /**
     * Generates an appropriate input name for the specified attribute name.
     *
     *
     * For example,
     *
     * ~~~
     * FormHelper::getInputName(Manufacturer::class, 'description', 1);
     * // The result is: Manufacturer[description_1]
     * FormHelper::getInputName('', 'description', 1);
     * // The result is: description_1
     * ~~~
     *
     * @param string   $formName      The form name or empty string.
     * @param string   $attributeName The attribute name.
     * @param int|null $idLanguage    The language ID for multi-language input or null.
     *
     * @return string The generated input name.
     *
     * @throws \InvalidArgumentException
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getInputName($formName, $attributeName, $idLanguage = null)
    {
        if ('' === trim($attributeName)) {
            throw new \InvalidArgumentException('The attribute name is empty.');
        }

        if (null !== $idLanguage) {
            $attributeName .= '_' . $idLanguage;
        }

        if ('' !== $formName) {
            $attributeName = $formName . '[' . $attributeName . ']';
        }

        return $attributeName;
    }

    /**
     * Generates an appropriate input ID by the specified input name.
     *
     * For example,
     *
     * ~~~
     * FormHelper::getInputIdByName(FormHelper::getInputName(Manufacturer::class, 'description', 1));
     * // The result is: manufacturer-description-1
     * ~~~
     *
     * @param string $inputName The input name.
     *
     * @return string The generated input ID.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getInputIdByName($inputName)
    {
        $id = strtolower($inputName);
        $id = str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $id);
        $id = preg_replace('/_+/', '-', $id);
        $id = trim($id, '-');

        return $id;
    }

    /**
     * Encodes special characters into HTML entities.
     *
     * @param string $content      The content to be encoded.
     * @param bool   $doubleEncode Whether to encode HTML entities in `$content`. If false, HTML entities in `$content` will not be further encoded.
     *
     * @return string The encoded content.
     *
     * @see decode()
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function encode($content, $doubleEncode = true)
    {
        return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
    }

    /**
     * Decodes special HTML entities back to the corresponding characters.
     *
     * @param string $content The content to be decoded.
     *
     * @return string The decoded content.
     *
     * @see encode()
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function decode($content)
    {
        return htmlspecialchars_decode($content, ENT_QUOTES);
    }

    /**
     * Generates the list used by the helper.
     *
     * For example,
     *
     * ~~~
     * $array = [
     *     ['123' => 'abc'],
     *     ['345' => 'def'],
     * ];
     * $result = FormHelper::generateList($array);
     * // The result is:
     * // [
     * //     ['id' => '123', 'name' => 'abc'],
     * //     ['id' => '345', 'name' => 'def']
     * // ]
     *
     * // The usage in a form definition:
     * array(
     *     'type'    => 'select',
     *     'label'   => 'Example',
     *     'name'    => 'example',
     *     'options' => array(
     *         'query' => $result,
     *         'id'    => 'id',
     *         'name'  => 'name',
     *     ),
     * )
     * ~~~
     *
     * @param array $values   List of key-value pairs.
     * @param bool  $withDash Whether to add "--" to the list.
     *
     * @return array
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function generateList(array $values, $withDash = false)
    {
        $list = [];

        if ($withDash) {
            $list[] = [
                'id'   => '',
                'name' => '--',
            ];
        }

        foreach ($values as $id => $name) {
            $list[] = [
                'id'   => $id,
                'name' => $name,
            ];
        }

        return $list;
    }
}