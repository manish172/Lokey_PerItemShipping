<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Lokey Coding, LLC - SOFTWARE LICENSE (v1.0)
 * that is bundled with this package in the file LICENSE.txt
 *
 * @category   Mage
 * @package    LKC_PerItemShipping
 * @copyright  Copyright (c) 2009 Lokey Coding, LLC <ip@lokeycoding.com>
 * @license    Lokey Coding, LLC - SOFTWARE LICENSE (v1.0)
 * @author     Lee Saferite <lee.saferite@lokeycoding.com>
 */

$this->startSetup();

//$this->run("");

$this->addAttribute(
    'catalog_product', 'lkc_pisa_rrr', array(
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
