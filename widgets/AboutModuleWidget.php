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

namespace zapalm\prestashopHelpers\widgets;

use zapalm\prestashopHelpers\helpers\FormHelper;

/**
 * About module widget.
 *
 * @version 0.11.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class AboutModuleWidget
{
    /** License: Academic Free License (AFL 3.0) */
    const LICENSE_AFL30 = 'Academic Free License (AFL 3.0)';

    /** @var string Site URL */
    protected $siteUrl = 'https://prestashop.modulez.ru';

    /** @var string Site logo URI */
    protected $siteLogoUri = 'img/marketplace-logo.png';

    /** @var string Module page URI */
    protected $moduleUri;

    /** @var string Main language ISO code */
    protected $mainLanguageIsoCode = 'ru';

    /** @var string License title */
    protected $licenseTitle = self::LICENSE_AFL30;

    /** @var string License URL */
    protected $licenseUrl;

    /** @var string Author title */
    protected $authorTitle;

    /** @var string Author icon URI */
    protected $authorIconUri = 'img/zapalm24x24.jpg';

    /** @var \Module Module */
    protected $module;

    /**
     * Constructor.
     *
     * @param \Module $module The module.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function __construct(\Module $module)
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
        return $this->render();
    }

    /**
     * Renders a block about a module.
     *
     * @return string
     *
     * @throws \LogicException When the configuration of the object is invalid.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function render()
    {
        $siteLanguageUri = '/en/';
        if (\Language::getIsoById(\Context::getContext()->cookie->id_lang) === $this->mainLanguageIsoCode) {
            $siteLanguageUri = '/' . $this->mainLanguageIsoCode . '/';
        }

        $siteUrlByLanguage = $this->siteUrl . $siteLanguageUri;
        if (false === filter_var($siteUrlByLanguage, FILTER_VALIDATE_URL)) {
            throw new \LogicException('Invalid configuration: site URL.');
        }

        $moduleUrl = $siteUrlByLanguage . $this->moduleUri;
        if (false === filter_var($moduleUrl, FILTER_VALIDATE_URL)) {
            throw new \LogicException('Invalid configuration: module URI.');
        }

        $websiteHtml = '
            <a class="link" href="' . FormHelper::encode($moduleUrl) . '" target="_blank" rel="noopener noreferrer">' .
                parse_url($this->siteUrl, PHP_URL_HOST) . '
            </a>
        ';

        $licenseHtml = $this->licenseTitle;
        if (null !== $this->licenseUrl) {
            if (0 === preg_match('/^\@\S+\@$/', $this->licenseUrl) && false === filter_var($this->licenseUrl, FILTER_VALIDATE_URL)) {
                throw new \LogicException('Invalid configuration: license URL.');
            }

            $licenseHtml = '
                <a class="link" href="' . FormHelper::encode($this->licenseUrl) . '" target="_blank" rel="noopener noreferrer">' .
                    FormHelper::encode($licenseHtml) . '
                </a>
            ';
        }

        $authorHtml = FormHelper::encode(null !== $this->authorTitle ? $this->authorTitle : $this->module->author);
        if (null !== $this->authorIconUri) {
            $authorIconUrl = $this->siteUrl . '/' . $this->authorIconUri;
            if (false === filter_var($authorIconUrl, FILTER_VALIDATE_URL)) {
                throw new \LogicException('Invalid configuration: author icon URI.');
            }

            $authorHtml .= ' <img src="' . FormHelper::encode($authorIconUrl) . '" alt="' . $this->module->l('Author') . '" width="24" height="24">';
        }

        $siteLogoUrl = $this->siteUrl . '/' . $this->siteLogoUri;
        if (false === filter_var($siteLogoUrl, FILTER_VALIDATE_URL)) {
            throw new \LogicException('Invalid configuration: site logo URI.');
        }

        $content =
            (version_compare(_PS_VERSION_, '1.6', '<') ? '<br class="clear">' : '') . '
            <div class="panel">
                <div class="panel-heading">
                    <img src="' . $this->module->getPathUri() . 'logo.png" width="16" height="16">
                    ' . $this->module->l('Module info') . '
                </div>
                <div class="form-wrapper">
                    <div class="row">               
                        <div class="form-group col-lg-4" style="display: block; clear: none !important; float: left; width: 33.3%;">
                            <span><b>' . $this->module->l('Version') . ':</b> ' . $this->module->version . '</span><br>
                            <span><b>' . $this->module->l('License') . ':</b> ' . $licenseHtml . '</span><br>
                            <span><b>' . $this->module->l('Website') . ':</b> ' . $websiteHtml . '</span><br>
                            <span><b>' . $this->module->l('Author') . ':</b> ' . $authorHtml . ' <br><br>
                        </div>
                        <div class="form-group col-lg-2" style="display: block; clear: none !important; float: left; width: 16.6%;">
                            <img width="250" alt="' . $this->module->l('Website') . '" src="' . FormHelper::encode($siteLogoUrl) . '">
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
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setModuleUri($moduleUri)
    {
        $this->moduleUri = $moduleUri;

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
        $this->licenseTitle = $licenseTitle;

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
        $this->licenseUrl = $licenseUrl;

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
     * Sets a author icon URI.
     *
     * @param string $authorIconUri The author icon URI.
     *
     * @return static
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function setAuthorIconUri($authorIconUri)
    {
        $this->authorIconUri = $authorIconUri;

        return $this;
    }
}