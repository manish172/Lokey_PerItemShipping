<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file OSL_LICENSE.txt
 *
 * @category   Mage
 * @package    Lokey_PerItemShipping
 * @copyright  Copyright (c) 2009-2013 Lokey Coding, LLC <ip@lokeycoding.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Lee Saferite <lee.saferite@lokeycoding.com>
 */

class Lokey_PerItemShipping_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getDefaultAdjustment(Mage_Core_Model_Store $store)
    {
        return round(floatval($store->getConfig('shipping/lokey_shippingadjustments/default_pisa_amount')), 2);
    }

    public function getUseQty(Mage_Catalog_Model_Product $product)
    {
        return ($product->hasData('lokey_pisa_useqty') && (bool)$product->getData('lokey_pisa_useqty'));
    }

    public function getRateRequestRemove(Mage_Catalog_Model_Product $product)
    {
        return ($product->hasData('lokey_pisa_rrr') && (bool)$product->getData('lokey_pisa_rrr'));
    }

    public function getAdjustmentAmount(Mage_Catalog_Model_Product $product, $default = 0.0)
    {
        $default = round($default, 2);

        if ($product->hasData('lokey_pisa_amount')) {
            $adjustment = round($product->getData('lokey_pisa_amount'), 2);
        } else {
            $adjustment = $default;
        }

        return max($adjustment, 0.0);
    }
}
