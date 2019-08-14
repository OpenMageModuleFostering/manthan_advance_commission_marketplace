<?php
class Manthan_Advancecommission_Block_Adminhtml_Catalog_Product_Categorycommission extends  Mage_Adminhtml_Block_Template
implements Mage_Adminhtml_Block_Widget_Tab_Interface {

	public function _construct()
	{
		parent::_construct();
		
		$this->setTemplate('advancecommission/catalog/product/categorycommission.phtml');
	}
	
    public function getTabLabel()
    {
    	return $this->__('Category Commission in(%)');
    }

    public function getTabTitle()
    {
    	return $this->__('Category Commission Set By Admin in(%)');
    }
    
    public function canShowTab()
    {
		return true;
    }
    
    public function isHidden()
    {
		if(Mage::app()->getRequest()->getParam('type') || Mage::app()->getRequest()->getParam('id')){
			return false;
		}	
    	return true;
    }

	public function getTabClass()
	{
		return 'category-commission-tab';
	}
	
	public function getSkipGenerateContent()
	{
		return false;
	}
	
	public function getTabUrl()
	{
		return '#';
	}

}

?>