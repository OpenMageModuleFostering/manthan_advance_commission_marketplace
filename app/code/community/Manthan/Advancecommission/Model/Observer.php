<?php
class Manthan_Advancecommission_Model_Observer extends Manthan_Marketplace_Model_Observer {

	public function saveSellerToOrderItem(Varien_Event_Observer $observer) 
	{
		if (!Mage::getStoreConfig('advancecommission/commission/active')) {
			return false;
		}
			$quoteItem = $observer->getItem();
			$orderItem = $observer->getOrderItem();
			
			$productId = $quoteItem->getProductId();
			$product = Mage::getModel('catalog/product')->load($productId);
			$marketplacePerProductShippingMethod = $this->getCurrentShippingObject()->getShippingMethod();
			$collection = Mage::getModel('marketplace/vendorproduct')->getCollection()
						->addFieldToFilter('product_id',$productId);
						
			if($collection->count() > 0 && !$quoteItem->getParentItemId())
			{
				if ($additionalOptions = $quoteItem->getOptionByCode('additional_options')) 
				{
					$options = $orderItem->getProductOptions();
					$options['additional_options'] = unserialize($additionalOptions->getValue());
					$orderItem->setProductOptions($options);
				}
				$userId = $collection->getFirstItem()->getUserId();
				$seller = Mage::getModel('marketplace/seller')->getCollection()
								->addFieldToFilter('user_id',$userId);
								
				$seller_admin_comission = $seller->getFirstItem()->getAdminCommissionByPercentage();
				
				if($product->getAdminProductCommission())
				{
					$seller_admin_comission = $product->getAdminProductCommission();
				}
				else if(!$product->getAdminProductCommission())
				{
					$categoryIds = $product->getCategoryIds();
					$ids = array_reverse($categoryIds);
					foreach($ids as $id)
					{
						$category = Mage::getModel('catalog/category')->load($id);
						if($category->getAdminCategoryCommission()){
							$seller_admin_comission = $category->getAdminCategoryCommission();
							break;
						}
					}					
				}
				$country = $seller->getFirstItem()->getCountry();
				
				if($marketplacePerProductShippingMethod == 'marketplaceproductshipping_marketplaceproductshipping')
				{
					$shippingPrice = Mage::getStoreConfig('carriers/marketplaceproductshipping/price') * $quoteItem->getQty();
					if($country == $this->getCurrentShippingObject()->getCountryId() && $product->getDomesticShippingCost()){
						$shippingPrice = $product->getDomesticShippingCost() * $quoteItem->getQty();
					}else if($country != $this->getCurrentShippingObject()->getCountryId() && $product->getInternationalShippingCost()){
						$shippingPrice = $product->getInternationalShippingCost() * $quoteItem->getQty();
					}
					$orderItem->setSellerPerProductShipping($shippingPrice);
				}
				$orderItem->setAdminOrderCommission($seller_admin_comission);
				$orderItem->setSellerId($seller->getFirstItem()->getId());
			}
	}
}

?>