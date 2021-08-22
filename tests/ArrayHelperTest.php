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

require __DIR__ . '/autoload.inc.php';

use zapalm\prestashopHelpers\helpers\ArrayHelper;
use zapalm\prestashopHelpers\tests\fixtures\FixtureA;

/**
 * Test case for ArrayHelper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ArrayHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test an array grouping.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testGroup()
    {
        // Test grouping and indexing an array of strings
        $arrayOfStrings = [
            ['id' => 123, 'data' => 'abc', 'name' => 'John', 'sex' => 'Male'],
            ['id' => 456, 'data' => 'def', 'name' => 'Jane', 'sex' => 'Female'],
        ];

        $result = ArrayHelper::group($arrayOfStrings, 'id', 'data');

        $this->assertEquals(
            [
                123 => [
                    'abc' => [
                        'id'   => 123,
                        'data' => 'abc',
                        'name' => 'John',
                        'sex'  => 'Male',
                    ],
                ],
                456 => [
                    'def' => [
                        'id'   => 456,
                        'data' => 'def',
                        'name' => 'Jane',
                        'sex'  => 'Female',
                    ],
                ],
            ],
            $result
        );

        // Test grouping and indexing an array of objects
        $arrayOfObjects = [
            new FixtureA(123, 'abc', 'John', 'Male'),
            new FixtureA(456, 'def', 'Jane', 'Female'),
        ];

        $result = ArrayHelper::group($arrayOfObjects, 'id', 'data');

        $this->assertEquals(
            [
                123 => [
                    'abc' => new FixtureA(123, 'abc', 'John', 'Male'),
                ],
                456 => [
                    'def' => new FixtureA(456, 'def', 'Jane', 'Female'),
                ],
            ],
            $result
        );

        // Test a value picking with grouping and indexing
        $result = ArrayHelper::group($arrayOfStrings, 'id', 'data', ['name', 'sex']);

        $correctResult = [
            123 => [
                'abc' => [
                    'name' => 'John',
                    'sex'  => 'Male',
                ],
            ],
            456 => [
                'def' => [
                    'name' => 'Jane',
                    'sex'  => 'Female',
                ],
            ],
        ];

        $this->assertEquals($correctResult, $result);

        // The same test but with array of objects as an input
        $this->assertEquals(
            $correctResult,
            ArrayHelper::group($arrayOfObjects, 'id', 'data', ['name', 'sex'])
        );
    }
}