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

use zapalm\prestashopHelpers\helpers\ValidateHelper;

/**
 * Test case for ValidateHelper.
 *
 * Terminology.
 * TLD: top-level domain.
 * IDN: internationalized domain name.
 *
 * @version 0.7.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ValidateHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test domain validator.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testIsDomain()
    {
        $domains = [
            // White list (valid non-IDN domains)
            'a.ru'                        => true, // Minimal length of domain name is 1, but the minimal length of TLD is 2
            'www.google.com'              => true,
            'google.com'                  => true,
            'modulez.ru'                  => true,
            'modulez123.com'              => true,
            'modulez-info.com'            => true,
            'sub.modulez.com'             => true,
            'sub.modulez-info.com'        => true,
            'modulez.com.au'              => true,
            'modulez.t.t.co'              => true,

            '123abc.com'                  => true, // A domain allowed to begin with a digit (RFC 1123)
            '123.com'                     => true, // A domain (but not a TLD) allows a set of only digits (RFC 1123)
            '111.222.333.com'             => true, // A domain and subdomains (but not a TLD) could legally be entirely numeric (RFC 1123)

            // Labels must be 63 characters or less (RFC 1034)
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.com' => true,

            // The maximum length of a full domain name with dots is 253 characters, but not 255:
            // https://devblogs.microsoft.com/oldnewthing/?p=7873
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.com' => true,

            // A full domain can contain many sub-domains and this is correct.
            // The maximum number of labels at the moment can be 127 in a theory, as written in Wikipedia (but less in a practice):
            // https://en.wikipedia.org/wiki/Domain_name
            'a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a.a' => true,

            // The restriction on the first character is relaxed to allow either a letter or a digit (RFC 1123)
            'google.123abc'               => true,

            // TLD may to consist of a single character, however, there are currently no single character TLDs in the root registry:
            // https://stackoverflow.com/a/21872376/1856214
            'modulez.t.t.c'               => true,

            // Black List
            'localhost'                   => false, // Unqualified sub-domain
            'modulez,com'                 => false, // Comma is not allowed
            'modulez.123'                 => false, // For now TLD can not consist of only digits
            '.com'                        => false, // Must start with [A-Za-z0-9]
            '.'                           => false, // Just the dot
            'ru.'                         => false, // Without TLD
            'modulez.com/users'           => false, // Not the TLD, but the URL
            '-modulez.com'                => false, // Cannot begin with the hyphen
            'sub.-modulez.com'            => false, // ...
            'sub.modulez.-com'            => false, // ...
            'modulez-.com'                => false, // Cannot end with the hyphen
            'sub.modulez-.com'            => false, // ...
            'modulez.com-'                => false, // ...

            // The maximum length of a full domain name with dots must not more then 253
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.com' => false,

            // Black List (invalid, because these are IDN domains)
            'престашоп.рф'                => false, // Russian, Unicode
            'xn--80aj2abdcii9c.xn--p1ai'  => false, // Russian, ASCII
            'xn--80a1acn3a.xn--j1amh'     => false, // Ukrainian, ASCII
            'xn--srensen-90a.example.com' => false, // German, ASCII
            'xn--mxahbxey0c.xn--xxaf0a'   => false, // Greek, ASCII
            'xn--fsqu00a.xn--4rr70v'      => false, // Chinese, ASCII

            // Black List (invalid, because these are IDN domains that additionally incorrect)
            'xn--престашоп.xn--рф'        => false, // Russian, Unicode
            'xn--prestashop.рф'           => false, // Russian, Unicode
        ];

        foreach ($domains as $domain => $isDomain) {
            $this->assertTrue(
                ValidateHelper::isDomain($domain) === $isDomain,
                $domain . ' is domain.'
            );
        }
    }

    /**
     * Test IDN validator.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function testIsIdn()
    {
        $domains = [
            // White list
            'р.ф'                  => true,  // Minimal length is 1 of each part of a domain name (Russian, Unicode)
            'престашоп.рф'         => true,  // Russian, Unicode
            'пошта.укр'            => true,  // Ukrainian, Unicode
            'Sörensen.example.com' => true,  // German, Unicode
            'εχαμπλε.ψομ'          => true,  // Greek, Unicode
            '例子.广告'              => true,  // Chinese, Unicode

            // Black List
            'хост'                 => false,  // Just the host name (Russian, Unicode)
            '.'                    => false,  // Just the dot
            'рф.'                  => false,  // Without TLD
            '.рф'                  => false,  // Without a domain name (Russian, Unicode)

            // Black List (invalid domains, because these are not an international)
            'google.com'           => false,  // English, ASCII
            'translate.google.com' => false,  // English, ASCII
        ];

        foreach ($domains as $domain => $isDomain) {
            $this->assertTrue(
                ValidateHelper::isIdn($domain) === $isDomain,
                $domain . ' is IDN.'
            );
        }
    }

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
            (new StdClass()),
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