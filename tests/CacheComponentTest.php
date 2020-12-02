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

// Try to find PrestaShop configuration file
$configPaths = [
    __DIR__ . '/../../../../../../config/config.inc.php', // From a module's directory
    __DIR__ . '/../../../../config/config.inc.php',       // From PrestaShop directory
    __DIR__ . '/../../p1612-1c/config/config.inc.php',    // From a local PrestaShop directory
    __DIR__ . '/../../p1768/config/config.inc.php',       // From another local PrestaShop directory
];

foreach ($configPaths as $path) {
    if (file_exists($path)) {
        require_once $path;
        break;
    }
}

if (false === defined('_PS_CONFIG_DIR_')) {
    throw new LogicException('Can not found PrestaShop configuration file: config.inc.php');
}

use zapalm\prestashopHelpers\components\cache\CacheProvider;

/**
 * Test case for the cache component.
 *
 * The example, how to run the test case when the tests directory in a module:
 * ```
 * phpunit --bootstrap vendor\autoload.php vendor\zapalm\prestashopHelpers\tests
 * ```
 *
 * The example, how to run the test case from this library directory:
 * ```
 * phpunit --bootstrap vendor\autoload.php tests\CacheComponentTest
 * ```
 *
 * @version 0.3.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class CacheComponentTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test cache set.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testSet()
    {
        $result = CacheProvider::getInstance()->set(__CLASS__, true);
        $this->assertTrue($result);

        $result = CacheProvider::getInstance(false)->set(__CLASS__, true);
        $this->assertTrue($result);
    }

    /**
     * Test cache get.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testGet()
    {
        $result = CacheProvider::getInstance()->get(__CLASS__);
        $this->assertTrue($result);

        $result = CacheProvider::getInstance(false)->get(__CLASS__);
        $this->assertTrue($result);
    }

    /**
     * Test cache flush.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testFlush()
    {
        $result = CacheProvider::getInstance()->flush();
        $this->assertTrue($result);

        $result = CacheProvider::getInstance(false)->flush();
        $this->assertTrue($result);
    }
}