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

use zapalm\prestashopHelpers\helpers\ValidateHelper;

// Try to find PrestaShop configuration file
$configPaths = [
    __DIR__ . '/../../../../../../config/config.inc.php', // From a module's directory
    __DIR__ . '/../../../../config/config.inc.php',       // From PrestaShop directory
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

/**
 * Test case for ValidateHelper.
 *
 * The example, how to run the test case: phpunit --bootstrap vendor\autoload.php vendor\zapalm\prestashopHelpers\tests
 *
 * @version 0.5.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ValidateHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test ASCII validator.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testIsAscii()
    {
        $emails = [
            // White list
            'no-reply@modulez.ru'        => true,  // English, ASCII
            'почта@престашоп.рф'         => false, // Russian, Unicode
            'квіточка@пошта.укр'         => false, // Ukrainian, Unicode
            'Dörte@Sörensen.example.com' => false, // German, Unicode
            'θσερ@εχαμπλε.ψομ'           => false, // Greek, Unicode
            '用户@例子.广告'               => false, // Chinese, Unicode
        ];

        foreach ($emails as $email => $isAscii) {
            $this->assertTrue(
                ValidateHelper::isAscii($email) === $isAscii,
                $email . ' is in ASCII.'
            );
        }
    }

    /**
     * Test IDN e-mail validator.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testIsIdnEmail()
    {
        $emails = [
            // White list
            'no-reply@modulez.ru'        => false, // English, ASCII
            'почта@престашоп.рф'         => true,  // Russian, Unicode
            'квіточка@пошта.укр'         => true,  // Ukrainian, Unicode
            'Dörte@Sörensen.example.com' => true,  // German, Unicode
            'θσερ@εχαμπλε.ψομ'           => true,  // Greek, Unicode
            '用户@例子.广告'               => true,  // Chinese, Unicode
        ];

        foreach ($emails as $email => $isIdnEmail) {
            $this->assertTrue(
                ValidateHelper::isIdnEmail($email) === $isIdnEmail,
                $email . ' is IDN e-mail.'
            );
        }
    }

    /**
     * Test Punycode domain validator.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testIsPunycodeDomain()
    {
        $domains = [
            // White list
            'почта@престашоп.рф'          => false, // Russian, Unicode
            'modulez.ru'                  => false, // English, ASCII
            'xn--80aj2abdcii9c.xn--p1ai'  => true,  // Russian, ASCII
            'xn--80a1acn3a.xn--j1amh'     => true,  // Ukrainian, ASCII
            'xn--srensen-90a.example.com' => true,  // German, ASCII
            'xn--mxahbxey0c.xn--xxaf0a'   => true,  // Greek, ASCII
            'xn--fsqu00a.xn--4rr70v'      => true,  // Chinese, ASCII

            // Black List
            'xn--престашоп.xn--рф'        => false, // Russian, Unicode
            'xn--prestashop.рф'           => false, // Russian, Unicode
        ];

        foreach ($domains as $domain => $isPunycode) {
            $this->assertTrue(
                ValidateHelper::isPunycodeDomain($domain) === $isPunycode,
                $domain . ' is in Punycode.'
            );
        }
    }

    /**
     * Test e-mail validator.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testIsEmail()
    {
        $emails = [
            // White list
            'no-reply@modulez.ru'        => true,  // English, ASCII
            'почта@престашоп.рф'         => true,  // Russian, Unicode
            'квіточка@пошта.укр'         => true,  // Ukrainian, Unicode
            'Dörte@Sörensen.example.com' => true,  // German, Unicode
            'θσερ@εχαμπλε.ψομ'           => true,  // Greek, Unicode
            '用户@例子.广告'               => true,  // Chinese, Unicode

            // Black List
            'mailbox@'                   => false,
            '@localhost'                 => false,
            '@'                          => false,
            ''                           => false,
        ];

        foreach ($emails as $email => $isEmail) {
            $this->assertTrue(
                ValidateHelper::isEmail($email) === $isEmail,
                $email . ' is e-mail.'
            );
        }
    }

    /**
     * Test ID validator.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testIsId()
    {
        $incorrectIds = [
            ($resource = fopen('php://stderr', 'r')),
            (new \StdClass()),
            [10],
            'text',
            '',
            false,
            true,
            null,
            0.0,
            '0',
            0,
            1.1,
            -1,
            '-2',
            -PHP_INT_MAX,
        ];

        foreach ($incorrectIds as $value) {
            $this->assertFalse(
                ValidateHelper::isId($value),
                print_r($value, true) . ' is not ID.'
            );
        }

        fclose($resource);

        $correctIds = [
            '1',
            PHP_INT_MAX,
            (string)PHP_INT_MAX,
        ];

        foreach ($correctIds as $value) {
            $this->assertTrue(
                ValidateHelper::isId($value),
                print_r($value, true) . ' is ID.'
            );
        }
    }
}