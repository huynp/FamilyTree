<?php

/**
 * @version     1.0.0
 * @package     com_familytree
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Huy <huynp88@gmail.com> - http://
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * Methods supporting a list of Familytree records.
 */
class FamilyTreeModelBuildtrees extends JModel
{


	/**
	 * This function gets the orderId, for anonymous users
	 * @author Max Milbers
	 */
	public function getOrderIdByOrderPass($orderNumber,$orderPass){

		$db = JFactory::getDBO();
		$q = 'SELECT `virtuemart_order_id` FROM `#__virtuemart_orders` WHERE `order_pass`="'.$db->getEscaped($orderPass).'" AND `order_number`="'.$db->getEscaped($orderNumber).'"';
		$db->setQuery($q);
		$orderId = $db->loadResult();

		return $orderId;

	}

	/**
	 * Load a single order, Attention, this function is not protected! Do the right manangment before, to be certain
     * we suggest to use getMyOrderDetails
	 */
	public function getOrderProductAttribute($virtuemart_order_id){

		//sanitize id
		$virtuemart_order_id = (int)$virtuemart_order_id;
		$db = JFactory::getDBO();
		
		// Get the order items
		$q = 'SELECT  product_attribute
		   FROM #__virtuemart_order_items i
		   WHERE `virtuemart_order_id`="'.$virtuemart_order_id.'" group by `virtuemart_order_item_id`';
		$db->setQuery($q);
		$product_attribute = $db->loadResult();
		return $product_attribute;
	}
	public function getTreeData() {


		$app = JFactory::getApplication();
		$input = $app->input;
		$orderNumber=$input->get('orderNumber', '', 'string');
		$orderPass=$input->get('orderPass', '', 'string');

		$query="select Tree_Data from `#__familytree_tree_data` where Order_Number='$orderNumber' and Order_Pass ='$orderPass'";
		$db = JFactory::getDBO();
		$treeData = $db->setQuery($query)->loadResult();
		if($treeData===null || $treeData=='')
		{
			$orderId = $this->getOrderIdByOrderPass($orderNumber,$orderPass);
			$product_attribute = $this->getOrderProductAttribute($orderId);
			
			 $hasRoot =strpos($product_attribute,'Yes Roots');
			 $Ancestry4Couple = strpos($product_attribute,'Ancestry - 4 Generation Couple'); 
			 $Ancestry4Individual = strpos($product_attribute,'Ancestry - 4 Generation Individual'); 
			 $Ancestry5Individual = strpos($product_attribute,'Ancestry - 5 Generation Individual'); 
			 $Descendant2 = strpos($product_attribute,'Descendant - 2 Generation'); 
			 $Descendant3 = strpos($product_attribute,'Descendant - 3 Generation'); 
			 $Descendant4 = strpos($product_attribute,'Descendant - 4 Generation'); 
			 $Descendant5 = strpos($product_attribute,'Descendant - 5 Generation'); 
			 $ancestorLevel =3;
			 $descendantLevel = 3;
			 if($Ancestry4Couple)
			 {
			 	$treeType = 'AncestorCouple';
			 	$ancestorLevel =4;
			 }
			 elseif($Ancestry4Individual){

			 	$treeType = 'AncestorSingle';
			 	$ancestorLevel =4;
			 }
			 elseif($Ancestry5Individual){

			 	$treeType = 'AncestorSingle';
			 	$ancestorLevel =5;
			 }
			 elseif($Descendant2){

			 	$treeType = 'Descendant';
			 	$descendantLevel =2;
			 }
			 elseif($Descendant3){

			 	$treeType = 'Descendant';
			 	$descendantLevel =3;
			 }
			 elseif($Descendant4){

			 	$treeType = 'Descendant';
			 	$descendantLevel =4;
			 }
			 elseif($Descendant5){

			 	$treeType = 'Descendant';
			 	$descendantLevel =5;
			 }
			$treeData = new stdClass();
			$treeData->mainPersonData =null;
			$treeData->spouseData =null;
			$treeData->treeType =$treeType;
			$treeData->hasRoot =$hasRoot;
			$treeData->descendantLevel =$descendantLevel;
			$treeData->ancestorLevel =$ancestorLevel;
			$treeData->allowAddBirthDay=false;

			$treeData = json_encode($treeData);
		}
		return $treeData ;
	}

	public function updateTreeData()
	{
		$app = JFactory::getApplication();
		$postData = $app->input->post;
		$orderNumber=$postData->get('orderNumber', '', 'string');
		$orderPass=$postData->get('orderPass', '', 'string');
		$treeData =$postData->get('treeData', '', 'string');
		$dataName =$postData->get('dataName', '', 'string');

		$db = JFactory::getDBO();
		//$query="select Tree_Data from `#__familytree_tree_data` where Order_Number='$orderNumber' and Order_Pass ='$orderPass'";
		//$treeDataToUpdate = $db->setQuery($query)->loadResult();

		//$arrayObject = json_decode($treeDataToUpdate);
		//$arrayObject[$dataName] = $treeData;
		//$test = json_encode($arrayObject);
		echo $treeData;
		echo "</br>";
		$encodeString = mysql_escape_string($treeData);
		$query="insert into `#__familytree_tree_data`(`Order_Number`,`Order_Pass`,`Tree_Data`) values('$orderNumber','$orderPass','$encodeString') ON DUPLICATE KEY UPDATE `Tree_Data`='$encodeString'";
		$result = $db->setQuery($query)->query();
		return $result;
	}

}
