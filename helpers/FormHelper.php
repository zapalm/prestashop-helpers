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

namespace zapalm\prestashopHelpers\helpers;

/**
 * Form helper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class FormHelper extends \HelperForm
{
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
     * The usage in a form definition:
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