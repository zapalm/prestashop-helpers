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

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Object helper.
 *
 * @version 0.3.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ObjectHelper
{
    /**
     * Returns attributes of PrestaShop object model.
     *
     * @param object $object The object.
     *
     * @return string[]
     *
     * @throws ReflectionException If the class does not exist.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getAttributes($object) {
        $attributes = array();

        $class = new ReflectionClass($object);
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (false === $property->isStatic()) {
                $attributeName = $property->getName();
                $attributes[$attributeName] = $object->$attributeName;
            }
        }

        return $attributes;
    }

    /**
     * Sets values to an object attributes.
     *
     * @param object   $object The object to update.
     * @param string[] $values Values to set.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function setAttributes($object, array $values) {
        foreach ($values as $propertyName => $propertyValue) {
            if (property_exists($object, $propertyName)) {
                $object->$propertyName = $propertyValue;
            }
        }
    }

    /**
     * Convert an object to an array.
     *
     * The method is needed when a namespace for a class and a scope for properties are used.
     *
     * @param object $object The object to convert.
     *
     * @return array
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function convertToArray($object)
    {
        $array      = (array)$object;
        $attributes = [];

        foreach ($array as $key => $value) {
            $attributeDefinitionParts   = explode("\0", $key);
            $attributeName              = $attributeDefinitionParts[count($attributeDefinitionParts) - 1];
            $attributes[$attributeName] = $value;
        }

        return $attributes;
    }
}