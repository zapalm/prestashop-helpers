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

// Try to find PrestaShop configuration file.
$configPaths = [
    __DIR__ . '/../../../../../../config/config.inc.php', // From a module's directory
    __DIR__ . '/../../../../config/config.inc.php',       // From PrestaShop root directory
    __DIR__ . '/../../localhost/config/config.inc.php',   // From a local PrestaShop directory
    __DIR__ . '/../../p1768/config/config.inc.php',       // From another local PrestaShop directory
    __DIR__ . '/../../PrestaShop/config/config.inc.php',  // From yet another local PrestaShop directory
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
