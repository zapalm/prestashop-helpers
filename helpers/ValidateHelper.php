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

namespace zapalm\prestashopHelpers\helpers;

/**
 * Validate helper.
 *
 * @version 0.4.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ValidateHelper extends \Validate
{
    /** Validator name to check whether a value is correct ID */
    const VALIDATOR_ID                          = 'isId';
    /** Validator name to check whether a value is correct UUID */
    const VALIDATOR_UUID                        = 'isUuid';
    /** Validator name to check whether a value is empty */
    const VALIDATOR_EMPTY                       = 'isEmpty';
    /** Validator name to check whether a value is not empty */
    const VALIDATOR_NOT_EMPTY                   = 'isNotEmpty';
    /** Validator name to check whether a value is correct Unsigned ID */
    const VALIDATOR_UNSIGNED_ID                 = 'isUnsignedId';
    /** Validator name to check whether a value is correct Unsigned Int */
    const VALIDATOR_UNSIGNED_INT                = 'isUnsignedInt';
    /** Validator name to check whether a value is correct Null Or Unsigned ID */
    const VALIDATOR_NULL_OR_UNSIGNED_ID         = 'isNullOrUnsignedId';
    /** Validator name to check whether a value is correct Int */
    const VALIDATOR_INT                         = 'isInt';
    /** Validator name to check whether a value is correct Table Or Identifier */
    const VALIDATOR_TABLE_OR_IDENTIFIER         = 'isTableOrIdentifier';
    /** Validator name to check whether a value is correct Bool ID */
    const VALIDATOR_BOOL_ID                     = 'isBoolId';
    /** Validator name to check whether a value is correct Array With IDs */
    const VALIDATOR_ARRAY_WITH_IDS              = 'isArrayWithIds';
    /** Validator name to check whether a value is correct IP */
    const VALIDATOR_IP2_LONG                    = 'isIp2Long';
    /** Validator name to check whether a value is Anything (the stub validator) */
    const VALIDATOR_ANYTHING                    = 'isAnything';
    /** Validator name to check whether a value is correct Email */
    const VALIDATOR_EMAIL                       = 'isEmail';
    /** Validator name to check whether a value is correct Module URL */
    const VALIDATOR_MODULE_URL                  = 'isModuleUrl';
    /** Validator name to check whether a value is correct Md5 */
    const VALIDATOR_MD5                         = 'isMd5';
    /** Validator name to check whether a value is correct Sha1 */
    const VALIDATOR_SHA1                        = 'isSha1';
    /** Validator name to check whether a value is correct Float */
    const VALIDATOR_FLOAT                       = 'isFloat';
    /** Validator name to check whether a value is correct Unsigned Float */
    const VALIDATOR_UNSIGNED_FLOAT              = 'isUnsignedFloat';
    /** Validator name to check whether a value is correct Optional Float */
    const VALIDATOR_OPT_FLOAT                   = 'isOptFloat';
    /** Validator name to check whether a value is correct Carrier Name */
    const VALIDATOR_CARRIER_NAME                = 'isCarrierName';
    /** Validator name to check whether a value is correct Image Size */
    const VALIDATOR_IMAGE_SIZE                  = 'isImageSize';
    /** Validator name to check whether a value is correct Name */
    const VALIDATOR_NAME                        = 'isName';
    /** Validator name to check whether a value is correct Hook Name */
    const VALIDATOR_HOOK_NAME                   = 'isHookName';
    /** Validator name to check whether a value is correct Mail Name */
    const VALIDATOR_MAIL_NAME                   = 'isMailName';
    /** Validator name to check whether a value is correct Mail Subject */
    const VALIDATOR_MAIL_SUBJECT                = 'isMailSubject';
    /** Validator name to check whether a value is correct Module Name */
    const VALIDATOR_MODULE_NAME                 = 'isModuleName';
    /** Validator name to check whether a value is correct Template Name */
    const VALIDATOR_TPL_NAME                    = 'isTplName';
    /** Validator name to check whether a value is correct Image Type Name */
    const VALIDATOR_IMAGE_TYPE_NAME             = 'isImageTypeName';
    /** Validator name to check whether a value is correct Price */
    const VALIDATOR_PRICE                       = 'isPrice';
    /** Validator name to check whether a value is correct Negative Price */
    const VALIDATOR_NEGATIVE_PRICE              = 'isNegativePrice';
    /** Validator name to check whether a value is correct Language ISO Code */
    const VALIDATOR_LANGUAGE_ISO_CODE           = 'isLanguageIsoCode';
    /** Validator name to check whether a value is correct Language Code */
    const VALIDATOR_LANGUAGE_CODE               = 'isLanguageCode';
    /** Validator name to check whether a value is correct State ISO Code */
    const VALIDATOR_STATE_ISO_CODE              = 'isStateIsoCode';
    /** Validator name to check whether a value is correct Numeric ISO Code */
    const VALIDATOR_NUMERIC_ISO_CODE            = 'isNumericIsoCode';
    /** Validator name to check whether a value is correct Discount Name */
    const VALIDATOR_DISCOUNT_NAME               = 'isDiscountName';
    /** Validator name to check whether a value is correct Catalog Name */
    const VALIDATOR_CATALOG_NAME                = 'isCatalogName';
    /** Validator name to check whether a value is correct Message */
    const VALIDATOR_MESSAGE                     = 'isMessage';
    /** Validator name to check whether a value is correct Country Name */
    const VALIDATOR_COUNTRY_NAME                = 'isCountryName';
    /** Validator name to check whether a value is correct Link Rewrite */
    const VALIDATOR_LINK_REWRITE                = 'isLinkRewrite';
    /** Validator name to check whether a value is correct Route Pattern */
    const VALIDATOR_ROUTE_PATTERN               = 'isRoutePattern';
    /** Validator name to check whether a value is correct Address */
    const VALIDATOR_ADDRESS                     = 'isAddress';
    /** Validator name to check whether a value is correct City Name */
    const VALIDATOR_CITY_NAME                   = 'isCityName';
    /** Validator name to check whether a value is correct Valid Search */
    const VALIDATOR_VALID_SEARCH                = 'isValidSearch';
    /** Validator name to check whether a value is correct Generic Name */
    const VALIDATOR_GENERIC_NAME                = 'isGenericName';
    /** Validator name to check whether a value is correct Clean HTML */
    const VALIDATOR_CLEAN_HTML                  = 'isCleanHtml';
    /** Validator name to check whether a value is correct Reference */
    const VALIDATOR_REFERENCE                   = 'isReference';
    /** Validator name to check whether a value is correct Password */
    const VALIDATOR_PASSWD                      = 'isPasswd';
    /** Validator name to check whether a value is correct Password for Admin */
    const VALIDATOR_PASSWD_ADMIN                = 'isPasswdAdmin';
    /** Validator name to check whether a value is correct Config Name */
    const VALIDATOR_CONFIG_NAME                 = 'isConfigName';
    /** Validator name to check whether a value is correct PHP Date Format */
    const VALIDATOR_PHP_DATE_FORMAT             = 'isPhpDateFormat';
    /** Validator name to check whether a value is correct Date Format */
    const VALIDATOR_DATE_FORMAT                 = 'isDateFormat';
    /** Validator name to check whether a value is correct Date */
    const VALIDATOR_DATE                        = 'isDate';
    /** Validator name to check whether a value is correct Birth Date */
    const VALIDATOR_BIRTH_DATE                  = 'isBirthDate';
    /** Validator name to check whether a value is correct Bool */
    const VALIDATOR_BOOL                        = 'isBool';
    /** Validator name to check whether a value is correct Phone Number */
    const VALIDATOR_PHONE_NUMBER                = 'isPhoneNumber';
    /** Validator name to check whether a value is correct EAN13 */
    const VALIDATOR_EAN13                       = 'isEan13';
    /** Validator name to check whether a value is correct UPC */
    const VALIDATOR_UPC                         = 'isUpc';
    /** Validator name to check whether a value is correct Post Code */
    const VALIDATOR_POST_CODE                   = 'isPostCode';
    /** Validator name to check whether a value is correct Zip Code Format */
    const VALIDATOR_ZIP_CODE_FORMAT             = 'isZipCodeFormat';
    /** Validator name to check whether a value is correct Order Way */
    const VALIDATOR_ORDER_WAY                   = 'isOrderWay';
    /** Validator name to check whether a value is correct Order By */
    const VALIDATOR_ORDER_BY                    = 'isOrderBy';
    /** Validator name to check whether a value is correct Tags List */
    const VALIDATOR_TAGS_LIST                   = 'isTagsList';
    /** Validator name to check whether a value is correct Product Visibility */
    const VALIDATOR_PRODUCT_VISIBILITY          = 'isProductVisibility';
    /** Validator name to check whether a value is correct Percentage */
    const VALIDATOR_PERCENTAGE                  = 'isPercentage';
    /** Validator name to check whether a value is correct Loaded Object */
    const VALIDATOR_LOADED_OBJECT               = 'isLoadedObject';
    /** Validator name to check whether a value is correct Color */
    const VALIDATOR_COLOR                       = 'isColor';
    /** Validator name to check whether a value is correct URL */
    const VALIDATOR_URL                         = 'isUrl';
    /** Validator name to check whether a value is correct Tracking Number */
    const VALIDATOR_TRACKING_NUMBER             = 'isTrackingNumber';
    /** Validator name to check whether a value is correct URL Or Empty */
    const VALIDATOR_URL_OR_EMPTY                = 'isUrlOrEmpty';
    /** Validator name to check whether a value is correct Absolute URL */
    const VALIDATOR_ABSOLUTE_URL                = 'isAbsoluteUrl';
    /** Validator name to check whether a value is correct MySQL Engine */
    const VALIDATOR_MYSQL_ENGINE                = 'isMySQLEngine';
    /** Validator name to check whether a value is correct Unix Name */
    const VALIDATOR_UNIX_NAME                   = 'isUnixName';
    /** Validator name to check whether a value is correct Table Prefix */
    const VALIDATOR_TABLE_PREFIX                = 'isTablePrefix';
    /** Validator name to check whether a value is correct File Name */
    const VALIDATOR_FILE_NAME                   = 'isFileName';
    /** Validator name to check whether a value is correct Directory Name */
    const VALIDATOR_DIR_NAME                    = 'isDirName';
    /** Validator name to check whether a value is correct Tab Name */
    const VALIDATOR_TAB_NAME                    = 'isTabName';
    /** Validator name to check whether a value is correct Weight Unit */
    const VALIDATOR_WEIGHT_UNIT                 = 'isWeightUnit';
    /** Validator name to check whether a value is correct Distance Unit */
    const VALIDATOR_DISTANCE_UNIT               = 'isDistanceUnit';
    /** Validator name to check whether a value is correct Sub Domain Name */
    const VALIDATOR_SUB_DOMAIN_NAME             = 'isSubDomainName';
    /** Validator name to check whether a value is correct Voucher Description */
    const VALIDATOR_VOUCHER_DESCRIPTION         = 'isVoucherDescription';
    /** Validator name to check whether a value is correct Sort Direction */
    const VALIDATOR_SORT_DIRECTION              = 'isSortDirection';
    /** Validator name to check whether a value is correct Label */
    const VALIDATOR_LABEL                       = 'isLabel';
    /** Validator name to check whether a value is correct Price Display Method */
    const VALIDATOR_PRICE_DISPLAY_METHOD        = 'isPriceDisplayMethod';
    /** Validator name to check whether a value is correct DNI Lite */
    const VALIDATOR_DNI_LITE                    = 'isDniLite';
    /** Validator name to check whether a value is correct Cookie */
    const VALIDATOR_COOKIE                      = 'isCookie';
    /** Validator name to check whether a value is correct String */
    const VALIDATOR_STRING                      = 'isString';
    /** Validator name to check whether a value is correct Reduction Type */
    const VALIDATOR_REDUCTION_TYPE              = 'isReductionType';
    /** Validator name to check whether a value is correct Localization Pack Selection */
    const VALIDATOR_LOCALIZATION_PACK_SELECTION = 'isLocalizationPackSelection';
    /** Validator name to check whether a value is correct Serialized Array */
    const VALIDATOR_SERIALIZED_ARRAY            = 'isSerializedArray';
    /** Validator name to check whether a value is correct Coordinate */
    const VALIDATOR_COORDINATE                  = 'isCoordinate';
    /** Validator name to check whether a value is correct Language ISO Code */
    const VALIDATOR_LANG_ISO_CODE               = 'isLangIsoCode';
    /** Validator name to check whether a value is correct Language File Name */
    const VALIDATOR_LANGUAGE_FILE_NAME          = 'isLanguageFileName';
    /** Validator name to check whether a value is correct Scene Zones */
    const VALIDATOR_SCENE_ZONES                 = 'isSceneZones';
    /** Validator name to check whether a value is correct Stock Management */
    const VALIDATOR_STOCK_MANAGEMENT            = 'isStockManagement';
    /** Validator name to check whether a value is correct SIRET */
    const VALIDATOR_SIRET                       = 'isSiret';
    /** Validator name to check whether a value is correct APE */
    const VALIDATOR_APE                         = 'isApe';
    /** Validator name to check whether a value is correct Controller Name */
    const VALIDATOR_CONTROLLER_NAME             = 'isControllerName';
    /** Validator name to check whether a value is correct PrestaShop Version */
    const VALIDATOR_PRESTA_SHOP_VERSION         = 'isPrestaShopVersion';
    /** Validator name to check whether a value is correct Order Invoice Number */
    const VALIDATOR_ORDER_INVOICE_NUMBER        = 'isOrderInvoiceNumber';

    /**
     * Returns whether a value is correct identifier.
     *
     * @param string|int $value The value to check.
     *
     * @return bool
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isId($value) {
        return (parent::isUnsignedInt($value) && (int)$value > 0);
    }

    /**
     * Returns whether a value is correct UUID identifier.
     *
     * @param string $value The value to check.
     *
     * @return bool
     *
     * @link https://en.wikipedia.org/wiki/Universally_unique_identifier
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isUuid($value) {
        return (1 === preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $value));
    }

    /**
     * Checks if the given value is empty.
     *
     * A value is considered empty if it is null, an empty array, or an empty string.
     * Note that this method is different from PHP empty(). It will return false when the value is 0.
     *
     * @param mixed $value The value to be checked.
     *
     * @return bool Whether the value is empty.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isEmpty($value)
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        return (null === $value || [] === $value || '' === $value);
    }

    /**
     * Checks if the given value is not empty.
     *
     * This is the opposite method of isEmpty() and it is useful for validation.
     *
     * @param mixed $value The value to be checked.
     *
     * @return bool Whether the value is not empty.
     *
     * @see isEmpty()
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isNotEmpty($value)
    {
        return (false === static::isEmpty($value));
    }

    /**
     * @inheritdoc
     *
     * Overridden, because ThirtyBees don't check for an empty value.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isEmail($email)
    {
        return (false === static::isEmpty($email) && parent::isEmail($email));
    }
}