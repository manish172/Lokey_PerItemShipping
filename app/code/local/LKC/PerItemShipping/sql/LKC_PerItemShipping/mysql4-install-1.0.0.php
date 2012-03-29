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


$this->startSetup();

//$this->run("");

$this->addAttribute('catalog_product', 'lkc_pisa_amount', array(
    'group' => 'Shipping',
    'type' => 'decimal',
    //'backend'  => 'catalog/product_attribute_backend_price',  // This would make the price either global or website, depending on the global config for pricing
    'label' => 'Shipping Adjustment',
    'input' => 'price',
    'class' => 'validate-number',
    'global' => 0,
    'required' => false
));

$this->endSetup();