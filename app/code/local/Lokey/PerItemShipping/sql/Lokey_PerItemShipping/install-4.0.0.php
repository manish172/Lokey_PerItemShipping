<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Lokey Coding, LLC - SOFTWARE LICENSE (v1.0)
 * that is bundled with this package in the file LICENSE.txt
 *
 * @category   Mage
 * @package    Lokey_PerItemShipping
 * @copyright  Copyright (c) 2009-2012 Lokey Coding, LLC <ip@lokeycoding.com>
 * @license    Lokey Coding, LLC - SOFTWARE LICENSE (v1.0)
 * @author     Lee Saferite <lee.saferite@lokeycoding.com>
 */

$this->startSetup();

$this->addAttribute(
    'catalog_product', 'lokey_pisa_amount', array(
        'group'    => 'Shipping',
        'type'     => 'decimal',
        'label'    => 'Shipping Adjustment',
        'input'    => 'price',
        'class'    => 'validate-number',
        'global'   => 0,
        'required' => false
    )
);

$this->addAttribute(
    'catalog_product', 'lokey_pisa_useqty', array(
        'group'    => 'Shipping',
        'type'     => 'int',
        'source'   => 'eav/entity_attribute_source_boolean',
        'label'    => 'Use Quantity',
        'input'    => 'select',
        'global'   => 0,
        'required' => false,
        'default'  => 1
    )
);

$this->addAttribute(
    'catalog_product', 'lokey_pisa_rrr', array(
        'group'    => 'Shipping',
        'type'     => 'int',
        'source'   => 'eav/entity_attribute_source_boolean',
        'label'    => 'Remove from Rate Request',
        'input'    => 'select',
        'global'   => 0,
        'required' => false,
        'default'  => 0
    )
);

$this->endSetup();
