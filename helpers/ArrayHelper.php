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
 * Array helper.
 *
 * @version 0.3.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ArrayHelper
{
    /**
     * Groups an array according to a specified column.
     *
     * The input array should be multidimensional or an array of objects.
     *
     * For example,
     *
     * ~~~
     * $array = [
     *     ['id' => '123', 'data' => 'abc'],
     *     ['id' => '345', 'data' => 'def'],
     * ];
     * $result = ArrayHelper::group($array, 'id', 'data');
     * // The result is:
     * // [
     * //     '123' => [
     * //         'abc' => [
     * //             'id'   => '123',
     * //             'data' => 'abc'
     * //         ]
     * //     ],
     * //     '345' => [
     * //         'def' => [
     * //             'id'   => '345',
     * //             'data' => 'def'
     * //         ]
     * //     ]
     * // ]
     * ~~~
     *
     * @param array|\Traversable $data          The source array.
     * @param string             $groupByColumn The column name to group the source array.
     * @param string|null        $indexByColumn The column name to index the returned array. If null, the resulting array will not be indexed.
     * @param string|array|null  $valueToPick   The column or columns from the returned array to maintain. If null, all values will be returned.
     *
     * @return array
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function group($data, $groupByColumn, $indexByColumn = null, $valueToPick = null)
    {
        if ([] === $data) {
            return [];
        }

        if (is_array($valueToPick)) {
            $valueToPick = array_combine($valueToPick, $valueToPick);
        }

        $result = [];

        foreach ($data as $item) {
            if (null !== $valueToPick && is_array($item)) {
                $dataToSave = [];
                foreach ($item as $key => $value) {
                    if (is_array($valueToPick)) {
                        if (array_key_exists($key, $valueToPick)) {
                            $dataToSave[] = $value;
                        }
                    } else {
                        $dataToSave = $value;
                    }
                }
            } else {
                $dataToSave = $item;
            }

            if (is_array($item)) {
                $groupKey = $item[$groupByColumn];
            } else {
                $groupKey = $item->$groupByColumn;
            }

            if (false === isset($result[$groupKey])) {
                $result[$groupKey] = [];
            }

            if (null === $indexByColumn) {
                $result[$groupKey][] = $dataToSave;
            } else {
                if (is_array($item)) {
                    $indexKey = $item[$indexByColumn];
                } else {
                    $indexKey = $item->$indexByColumn;
                }

                $result[$groupKey][$indexKey] = $dataToSave;
            }
        }

        return $result;
    }

    /**
     * Indexes an array according to a specified key.
     *
     * The input array should be multidimensional or an array of objects.
     *
     * For example,
     *
     * ~~~
     * $array = [
     *     ['id' => '123', 'data' => 'abc'],
     *     ['id' => '345', 'data' => 'def'],
     * ];
     * $result = ArrayHelper::index($array, 'id');
     * // The result is:
     * // [
     * //     '123' => ['id' => '123', 'data' => 'abc'],
     * //     '345' => ['id' => '345', 'data' => 'def'],
     * // ]
     * ~~~
     *
     * @param array|\Traversable $array The array that needs to be indexed.
     * @param string             $key   The column name to index the array.
     *
     * @return array
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function index($array, $key)
    {
        $result = [];

        foreach ($array as $item) {
            if (is_object($item)) {
                $result[$item->$key] = $item;
            } else {
                $result[$item[$key]] = $item;
            }
        }

        return $result;
    }

    /**
     * Returns values of a specified column in an array.
     *
     * The input array should be multidimensional or an array of objects.
     *
     * For example,
     *
     * ~~~
     * $array = [
     *     ['id' => '123', 'data' => 'abc'],
     *     ['id' => '345', 'data' => 'def'],
     * ];
     * $result = ArrayHelper::getColumn($array, 'id');
     * // The result is: ['123', '345']
     * ~~~
     *
     * @param array|\Traversable $array    The source array.
     * @param string             $column   The column name to be returned.
     * @param bool               $keepKeys Whether to keep keys of the source array.
     * @param bool               $unique   Whether to return only unique values.
     *
     * @return array
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getColumn($array, $column, $keepKeys = true, $unique = false)
    {
        $result = [];
        foreach ($array as $key => $item) {
            if (is_object($item) && property_exists($item, $column)) {
                $value = $item->$column;
            } elseif (isset($item[$column])) {
                $value = $item[$column];
            } else {
                continue;
            }

            if ($keepKeys) {
                $result[$key] = $value;
            } else {
                $result[] = $value;
            }
        }

        if ($unique) {
            $result = array_unique($result);
        }

        return $result;
    }
}
