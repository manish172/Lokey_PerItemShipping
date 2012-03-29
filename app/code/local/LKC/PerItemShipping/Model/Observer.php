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
class LKC_PerItemShipping_Model_Observer
{

    public function filterRateRequest(Varien_Event_Observer $observer)
    {
        $store = $observer->getStore();
        $request = $observer->getRequest();
        $allItems = $observer->getAllItems();
        $removedItems = $observer->getRemovedItems();

        foreach ($allItems as $item)
        {
            $product = Mage::getModel('catalog/product')->setStoreId($store->getId())->load($item->getProductId());
            $rateRequestRemove = Mage::helper('LKC_PerItemShipping')->getRateRequestRemove($product);

            if ($rateRequestRemove && ! $removedItems->getItemById($item->getId()))
            {
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

        if (!$request->getFreeShipping())
        {
            $itemAdjustments = $adjustments->getItems();

            $defaultAdjustment = Mage::helper('LKC_PerItemShipping')->getDefaultAdjustment($store);

            foreach ($allItems as $item)
            {
                $qty = $item->getQty();
                if($item->getParentItem())
                {
                    $qty *= $item->getParentItem()->getQty();
                }
                $qty -= $item->getFreeQuantity();
                $qty = max($qty, 0);

                if($request->getFreeShipping() || $qty === 0)
                {
                    continue;
                }

                $product = Mage::getModel('catalog/product')->setStoreId($store->getId())->load($item->getProductId());

                if (!$product->getTypeInstance()->isVirtual())
                {
                    $useQty = Mage::helper('LKC_PerItemShipping')->getUseQty($product);
                    $adjustment = Mage::helper('LKC_PerItemShipping')->getAdjustmentAmount($product, $defaultAdjustment);

                    if ($useQty)
                    {
                        if ($item->getParentItem())
                        {
                            $qty *= $item->getParentItem()->getQty();
                        }
                        $adjustment *= $qty;
                    }

                    if (!isset($itemAdjustments[$item->getId()]))
                    {
                        $itemAdjustments[$item->getId()] = 0.0;
                    }

                    $itemAdjustments[$item->getId()] += $adjustment;
                }
            }

            $adjustments->setItems($itemAdjustments);
        }
        
        return $this;
    }

}