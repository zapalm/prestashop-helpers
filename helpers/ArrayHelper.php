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
 * Array helper.
 *
 * @version 0.4.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ArrayHelper
{
    /**
     * Groups an array according to a specified column.
     *
     * An input array my be a multidimensional or an array of objects.
     *
     * Note: a structure of child elements in an array must be the same and attributes for grouping and
     * indexing must be accessible for reading (be public or has getters).
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
     * @param array|\Traversable   $data          The source array.
     * @param string               $groupByColumn The column name to group the source array.
     * @param string|null          $indexByColumn The column name to index the returned array. If null, the resulting array will not be indexed.
     * @param string|string[]|null $valueToPick   The column or columns from the returned array to maintain. If null, all values will be returned.
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

        if (is_string($valueToPick)) {
            $valueToPick = [$valueToPick];
        }

        $result = [];

        $item = reset($data);
        if (is_object($item)) {
            $groupByColumnGetter         = 'get' . $groupByColumn;
            $isGroupByColumnGetterExists = method_exists($item, $groupByColumnGetter);

            $indexByColumnGetter         = 'get' . $indexByColumn;
            $isIndexByColumnGetterExists = method_exists($item, $indexByColumnGetter);

        } else {
            $isGroupByColumnGetterExists = false;
            $isIndexByColumnGetterExists = false;
        }

        foreach ($data as $item) {
            if (null !== $valueToPick) {
                $dataToSave = [];
                if (is_array($item)) {
                    foreach ($valueToPick as $attribute) {
                        if (array_key_exists($attribute, $item)) {
                            $dataToSave[$attribute] = $item[$attribute];
                        }
                    }
                } else {
                    foreach ($valueToPick as $attribute) {
                        $getter = "get{$attribute}";
                        if (method_exists($item, $getter)) {
                            $dataToSave[$attribute] = $item->$getter();
                        } else {
                            $dataToSave[$attribute] = $item->$attribute;
                        }
                    }
                }
            } else {
                $dataToSave = $item;
            }

            if (is_array($item)) {
                $groupKey = $item[$groupByColumn];
            } else {
                if ($isGroupByColumnGetterExists) {
                    $groupKey = $item->$groupByColumnGetter();
                } else {
                    $groupKey = $item->$groupByColumn;
                }
            }

            if (false === array_key_exists($groupKey, $result)) {
                $result[$groupKey] = [];
            }

            if (null === $indexByColumn) {
                $result[$groupKey][] = $dataToSave;
            } else {
                if (is_array($item)) {
                    $indexKey = $item[$indexByColumn];
                } else {
                    if ($isIndexByColumnGetterExists) {
                        $indexKey = $item->$indexByColumnGetter();
                    } else {
                        $indexKey = $item->$indexByColumn;
                    }
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
                $getter = 'get' . $key;
                if (method_exists($item, $getter)) {
                    $result[$item->$getter()] = $item;
                } else {
                    $result[$item->$key] = $item;
                }
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
            if (is_object($item)) {
                $getter = 'get' . $column;
                if (method_exists($item, $getter)) {
                    $value = $item->$getter();
                } elseif (isset($item->$column) || property_exists($item, $column)) { // Checking magic and regular properties both
                    $value = $item->$column;
                } else {
                    continue;
                }
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