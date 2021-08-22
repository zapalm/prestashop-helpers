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

use zapalm\prestashopHelpers\components\cache\CacheProvider;

/**
 * Test case for the cache component.
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