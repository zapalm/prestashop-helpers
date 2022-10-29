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

use zapalm\prestashopHelpers\helpers\FileHelper;

require __DIR__ . '/autoload.inc.php';

/**
 * Test case for FileHelper.
 *
 * @version 0.1.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class FileHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test zip extraction.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testExtractZip()
    {
        $result = FileHelper::extractZip(
            __DIR__ . '/fixtures/FixtureA.zip',
            __DIR__ . '/fixtures',
            $error
        );
        $this->assertTrue($result, $error);
        $this->assertNull($error);

        $result = FileHelper::extractZip(
            __DIR__ . '/fixtures/FixtureA.php',
            __DIR__ . '/fixtures',
            $error
        );
        $this->assertFalse($result);
        $this->assertNotNull($error);
    }
}