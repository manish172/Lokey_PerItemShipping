<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Lokey Coding, LLC - SOFTWARE LICENSE (v1.0)
 * that is bundled with this package in the file LKC_LICENSE.txt.
 *
 * @category   Mage
 * @package    LKC_PerItemShipping
 * @copyright  Copyright (c) 2009 Lokey Coding, LLC <ip@lokeycoding.com>
 * @license    Lokey Coding, LLC - SOFTWARE LICENSE (v1.0)
 * @author     Lee Saferite <lee.saferite@lokeycoding.com>
 */


class LKC_PerItemShipping_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getDefaultAdjustment(Mage_Core_Model_Store $store)
    {
        return round(floatval($store->getConfig('shipping/lkc_shippingadjustments/default_pisa_amount')), 2);
    }

    public function getUseQty(Mage_Catalog_Model_Product $product)
    {
        return ($product->hasData('lkc_pisa_useqty') && (bool) $product->getData('lkc_pisa_useqty'));
    }

    public function getRateRequestRemove(Mage_Catalog_Model_Product $product)
    {
        return ($product->hasData('lkc_pisa_rrr') && (bool) $product->getData('lkc_pisa_rrr'));
    }

    public function getAdjustmentAmount(Mage_Catalog_Model_Product $product, $default = 0.0)
    {
        $default = round($default, 2);

        if ($product->hasData('lkc_pisa_amount'))
        {
            $adjustment = round($product->getData('lkc_pisa_amount'), 2);
        }
        else
        {
            $adjustment = $default;
        }

        return max($adjustment, 0.0);
    }

}
