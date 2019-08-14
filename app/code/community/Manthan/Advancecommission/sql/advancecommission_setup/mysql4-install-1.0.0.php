<?php
$installer = $this;
$installer->startSetup();
$createSetup = new Mage_Eav_Model_Entity_Setup('core_setup');
$createSetup->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'admin_category_commission', array(
    'group'         	=> 'General Information',
    'input'         	=> 'text',
    'type'          	=> 'int',
	'label'         	=> 'Commission of Admin(%)',
    'backend'       	=> '',
	'searchable'    	=> false,
	'filterable'    	=> false,
	'unique'        	=> true,
    'visible'       	=> true,
    'required'      	=> false,
    'visible_on_front'	=> false,
	'user_defined'      => true,
	'sort_order'		=> 2,
    'global'        	=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));
$createSetup->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'admin_product_commission', array(
    'group'             => 'Prices',
    'type'              => 'int',
    'backend'           => '',
    'frontend'          => '',
    'label'             => 'Product Commission(%)',
    'input'             => 'text',
    'class'             => 'product-commission',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => 1,
    'required'          => 0,
    'user_defined'      => 0,
    'searchable'        => 0,
    'filterable'        => 0,
    'comparable'        => 0,
    'visible_on_front'  => 0,
    'unique'            => 0,
	'sort_order'		=> 3,
	'apply_to'          => 'simple,configurable,grouped,bundle,virtual,downloadable',
    'is_configurable'   => 0
));
$installer->endSetup();
?>