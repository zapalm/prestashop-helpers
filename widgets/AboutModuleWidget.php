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

namespace zapalm\prestashopHelpers\widgets;

use Context;
use Exception;
use Language;
use LogicException;
use Module;
use zapalm\prestashopHelpers\helpers\FormHelper;
use zapalm\prestashopHelpers\helpers\TranslateHelper;

/**
 * About module widget.
 *
 * @version 0.14.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class AboutModuleWidget
{
    /** License: Academic Free License (AFL 3.0) */
    const LICENSE_AFL30 = 'Academic Free License (AFL 3.0)';

    /** License: Open Software License (OSL 3.0) */
    const LICENSE_OSL30 = 'Open Software License (OSL 3.0)';

    /** License: GNU General Public License (GNU 3.0) */
    const LICENSE_GNU30 = 'GNU General Public License (GNU 3.0)';

    /** License: MIT License */
    const LICENSE_MIT = 'MIT License';

    /** License: Open-source license */
    const LICENSE_OPEN_SOURCE = 'Open-source license';

    /** License: Proprietary license */
    const LICENSE_PROPRIETARY = 'Proprietary license';

    /** License: Proprietary license for closed-source software */
    const LICENSE_PROPRIETARY_CLOSED_SOURCE = 'Proprietary license for closed-source software';

    /** License: Proprietary license for source-available software */
    const LICENSE_PROPRIETARY_SOURCE_AVAILABLE = 'Proprietary license for source-available software';

    /** @var string Site URL */
    protected $siteUrl = 'https://prestashop.modulez.ru';

    /** @var string Site logo URI */
    protected $siteLogoUri = 'img/marketplace-logo.png';

    /** @var string Module page URI */
    protected $moduleUri;

    /** @var string Main language ISO code */
    protected $mainLanguageIsoCode = 'ru';

    /** @var string License title */
    protected $licenseTitle;

    /** @var string License URL */
    protected $licenseUrl;

    /** @var string Author title */
    protected $authorTitle;

    /** @var Module Module */
    protected $module;

    /** @var int Product ID of a module on its homepage. */
    protected $productId;

    /**
     * Constructor.
     *
     * @param Module $module The module.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Renders a block about a module.
     *
     * @return string
     *
     * @see render()
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function __toString()
    {
        try {
            return $this->render();
        } catch (Exception $e) {
            return $e->getMessage(); // Because method __toString() must not throw an exception
        }
    }

    /**
     * Renders a block about a module.
     *
     * @return string
     *
     * @throws LogicException When the configuration of the object is invalid.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function render()
    {
        $siteLanguageUri = '/en/';
        if (Language::getIsoById(Context::getContext()->cookie->id_lang) === $this->mainLanguageIsoCode) {
            $siteLanguageUri = '/' . $this->mainLanguageIsoCode . '/';
        }

        $siteUrlByLanguage = $this->siteUrl . $siteLanguageUri;
        if (false === filter_var($siteUrlByLanguage, FILTER_VALIDATE_URL)) {
            throw new LogicException('Invalid configuration: site URL.');
        }

        if (null === $this->moduleUri && null !== $this->productId) {
            $this->moduleUri = $this->productId . '-' . $this->module->name . '.html';
        }
        $moduleUrl = $siteUrlByLanguage . $this->moduleUri;
        if (false === filter_var($moduleUrl, FILTER_VALIDATE_URL)) {
            throw new LogicException('Invalid configuration: module URI.');
        }

        $websiteHtml = '
            <a class="link" href="' . FormHelper::encode($moduleUrl) . '" target="_blank" rel="noopener noreferrer">' .
                parse_url($this->siteUrl, PHP_URL_HOST) . '
            </a>
        ';

        if (null === $this->licenseTitle && null === $this->licenseUrl) {
            $this->setLicenseTitle(static::LICENSE_OPEN_SOURCE);
            $this->setLicenseUrl('https://prestashop.modulez.ru/en/content/3-terms-and-conditions-of-use#open-source-license');
        }

        $licenseHtml = $this->licenseTitle;
        if (null !== $this->licenseUrl) {
            if (false === filter_var($this->licenseUrl, FILTER_VALIDATE_URL)) {
                throw new LogicException('Invalid configuration: license URL.');
            }

            $licenseHtml = '
                <a class="link" href="' . FormHelper::encode($this->licenseUrl) . '" target="_blank" rel="noopener noreferrer">' .
                    FormHelper::encode($licenseHtml) . '
                </a>
            ';
        }

        $authorHtml = FormHelper::encode(null !== $this->authorTitle ? $this->authorTitle : $this->module->author);

        $siteLogoUrl = $this->siteUrl . '/' . $this->siteLogoUri;
        if (false === filter_var($siteLogoUrl, FILTER_VALIDATE_URL)) {
            throw new LogicException('Invalid configuration: site logo URI.');
        }

        $content =
            (version_compare(_PS_VERSION_, '1.6', '<') ? '<br class="clear">' : '') . '
            <div class="panel">
                <div class="panel-heading">
                    <img src="' . $this->module->getPathUri() . 'logo.png" width="16" height="16" alt="">
                    ' . $this->translate('Module info') . '
                </div>
                <div class="form-wrapper">
                    <div class="row">               
                        <div class="form-group col-lg-4" style="display: block; clear: none !important; float: left; width: 33.3%;">
                            <span><b>' . $this->translate('Version') . ':</b> ' . $this->module->version . '</span><br>
                            <span><b>' . $this->translate('License') . ':</b> ' . $licenseHtml . '</span><br>
                            <span><b>' . $this->translate('Website') . ':</b> ' . $websiteHtml . '</span><br>
                            <span><b>' . $this->translate('Author') . ':</b> ' . $authorHtml . '</span><br><br>
                        </div>
                        <div class="form-group col-lg-2" style="display: block; clear: none !important; float: left; width: 16.6%;">
                            <img width="250" alt="' . $this->translate('Website') . '" src="' . FormHelper::encode($siteLogoUrl) . '">
                        </div>
                    </div>
                </div>
            </div> ' .
            (version_compare(_PS_VERSION_, '1.6', '<') ? '<br class="clear">' : '') . '
        ';

        return $content;
    }

    /**
     * Sets a module URI.
     *
     * @param string $moduleUri The module URI.
     *
     * @return static
     *
     * @see setProductId() An alternative method.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setModuleUri($moduleUri)
    {
        $this->moduleUri = $moduleUri;

        return $this;
    }

    /**
     * Sets a product ID of a module on its homepage.
     *
     * @param int $productId The product ID.
     *
     * @return static
     *
     * @see setModuleUri() An alternative method.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setProductId($productId)
    {
        $this->productId = (int)$productId;

        return $this;
    }

    /**
     * Sets a license title.
     *
     * @param string $licenseTitle The license title.
     *
     * @return static
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setLicenseTitle($licenseTitle)
    {
        if ('@license_text@' === $licenseTitle) {
            $this->licenseTitle = $this->translate(static::LICENSE_PROPRIETARY);
        } else {
            $this->licenseTitle = $this->translate($licenseTitle);
        }

        return $this;
    }

    /**
     * Sets a site URL.
     *
     * @param string $siteUrl the site URL.
     *
     * @return static
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setSiteUrl($siteUrl)
    {
        $this->siteUrl = $siteUrl;

        return $this;
    }

    /**
     * Sets a site logo URI.
     *
     * @param string $siteLogoUri The site logo URI.
     *
     * @return static
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setSiteLogoUri($siteLogoUri)
    {
        $this->siteLogoUri = $siteLogoUri;

        return $this;
    }

    /**
     * Sets a main language ISO code.
     *
     * @param string $mainLanguageIsoCode The main language ISO code.
     *
     * @return static
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setMainLanguageIsoCode($mainLanguageIsoCode)
    {
        $this->mainLanguageIsoCode = strtolower($mainLanguageIsoCode);

        return $this;
    }

    /**
     * Sets a license URL.
     *
     * @param string $licenseUrl The license URL.
     *
     * @return static
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setLicenseUrl($licenseUrl)
    {
        if ($licenseUrl !== '@license_url@') {
            $this->licenseUrl = $licenseUrl;
        }

        return $this;
    }

    /**
     * Sets a author title.
     *
     * @param string $authorTitle The author title.
     *
     * @return static
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setAuthorTitle($authorTitle)
    {
        $this->authorTitle = $authorTitle;

        return $this;
    }

    /**
     * Translates a sentence.
     *
     * @param string $sentence The sentence.
     *
     * @return string The translated sentence or the same sentence if it was not translated before.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    private function translate($sentence)
    {
        return TranslateHelper::translate(
            $sentence,
            static::class,
            null,
            __DIR__ . '/../translations',
            true
        );
    }
}