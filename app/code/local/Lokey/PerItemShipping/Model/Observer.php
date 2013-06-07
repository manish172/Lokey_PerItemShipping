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

class Lokey_PerItemShipping_Model_Observer
{
    public function filterRateRequest(Varien_Event_Observer $observer)
    {
        $store = $observer->getStore();
        $request = $observer->getRequest();
        $allItems = $observer->getAllItems();
        $removedItems = $observer->getRemovedItems();

        foreach ($allItems as $item) {
            $product = Mage::getModel('catalog/product')->setStoreId($store->getId())->load($item->getProductId());
            $rateRequestRemove = Mage::helper('Lokey_PerItemShipping')->getRateRequestRemove($product);

            if ($rateRequestRemove && !$removedItems->getItemById($item->getId())) {
                $removedItems->addItem($item);
            }
        }

        return $this;
    }

    public function calculateAdjustment(Varien_Event_Observer $observer)
    {
        $store = $observer->getStore();
        $request = $observer->getRequest();
        $allItems = $observer->getAllItems();
        $adjustments = $observer->getAdjustments();

        if (!$request->getFreeShipping()) {
            $itemAdjustments = $adjustments->getItems();

            $defaultAdjustment = Mage::helper('Lokey_PerItemShipping')->getDefaultAdjustment($store);

            foreach ($allItems as $item) {
                // Skip child items in main loop
                if ($item->getParentItem()) {
                    continue;
                }

                $qty = (float)($item->getFreeShipping() === true ? 0 : $item->getQty() - $item->getFreeShipping());

                // Skip free shipping items
                if ($qty <= 0.0) {
                    continue;
                }

                $product = Mage::getModel('catalog/product')->setStoreId($store->getId())->load($item->getProductId());
                $adjustment = Mage::helper('Lokey_PerItemShipping')->getAdjustmentAmount($product, $defaultAdjustment);

                // Skip virtual products
                if ($product->getTypeInstance()->isVirtual()) {
                    continue;
                }

                if ($item->getHasChildren()) {
                    foreach ($item->getChildren() as $childItem) {
                        $childQty = (float)($childItem->getFreeShipping() === true ? 0 : $childItem->getQty() - $childItem->getFreeShipping());

                        // Skip free shipping items
                        if ($childQty <= 0.0) {
                            continue;
                        }

                        $childProduct = Mage::getModel('catalog/product')->setStoreId($store->getId())->load($childItem->getProductId());
                        $childAdjustment = Mage::helper('Lokey_PerItemShipping')->getAdjustmentAmount($childProduct, $defaultAdjustment);

                        // Skip virtual products
                        if ($childProduct->getTypeInstance()->isVirtual()) {
                            continue;
                        }

                        if (Mage::helper('Lokey_PerItemShipping')->getUseQty($childProduct)) {
                            $adjustment += ($childAdjustment * $childQty);
                        } else {
                            $adjustment += $childAdjustment;
                        }
                    }
                }

                if (!isset($itemAdjustments[$item->getId()])) {
                    $itemAdjustments[$item->getId()] = 0.0;
                }

                if (Mage::helper('Lokey_PerItemShipping')->getUseQty($product)) {
                    $itemAdjustments[$item->getId()] += ($adjustment * $qty);
                } else {
                    $itemAdjustments[$item->getId()] += $adjustment;
                }
            }

            $adjustments->setItems($itemAdjustments);
        }

        return $this;
    }
}
