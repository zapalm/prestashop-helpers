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
 * Product helper.
 *
 * @version 0.2.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class ProductHelper
{
    /**
     * Returns whether a product is available for sale (or for preorder).
     *
     * Stock remains of a product must be checked separately from this method.
     *
     * @param \Product $product The product to check.
     *
     * @return bool
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function isProductAvailableWhenOutOfStock(\Product $product)
    {
        if (false === (bool)$product->available_for_order) {
            return false;
        }

        if ($product->isFullyLoaded) {
            $productOutOfStock = (int)$product->out_of_stock;
        } else {
            $productOutOfStock = \StockAvailable::outOfStock($product->id);
        }

        if (0 === $productOutOfStock) { // 0 - Deny orders, 1 - Allow orders, 2 - Use a global option
            return false;
        }

        $stockManagement = (bool)\Configuration::get('PS_STOCK_MANAGEMENT');
        $orderOutOfStock = (bool)\Configuration::get('PS_ORDER_OUT_OF_STOCK');
        if (false === $stockManagement || 1 === $productOutOfStock || (2 === $productOutOfStock && $orderOutOfStock)) {
            return true;
        }

        return false;
    }

    /**
     * Returns a sum of a product stock remains.
     *
     * The method is necessary because it is more clear to use then core methods.
     *
     * @param int   $productId     The product ID.
     * @param int   $combinationId The combination ID.
     * @param int[] $warehousesIds Warehouses IDs for which you want to get stock remains or empty array to use all of available warehouses.
     *
     * @return int The sum of stock remains of the product.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getProductRemains($productId, $combinationId = 0, $warehousesIds = [])
    {
        $productId     = (int)$productId;
        $combinationId = (int)$combinationId;

        if ([] === $warehousesIds) {
            $warehousesList = \Warehouse::getProductWarehouseList($productId, $combinationId);
            $warehousesIds  = ArrayHelper::getColumn($warehousesList, 'id_warehouse');
            $warehousesIds  = array_map('intval', $warehousesIds);
        }

        return \Product::getRealQuantity($productId, $combinationId, $warehousesIds);
    }
}