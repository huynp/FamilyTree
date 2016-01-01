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
	public function getOrder($virtuemart_order_id){
		//sanitize id
		$virtuemart_order_id = (int)$virtuemart_order_id;
		$db = JFactory::getDBO();
		$orderDetail = array();
		$q = "select o.*, CONCAT_WS(' ',u.first_name,u.middle_name,u.last_name) AS order_name "
		.', u.email as order_email'
		.' FROM #__virtuemart_orders as o
				LEFT JOIN #__virtuemart_order_userinfos as u
				ON u.virtuemart_order_id = o.virtuemart_order_id AND u.address_type="BT"'
		.' Where o.virtuemart_order_id='.$virtuemart_order_id;
		$db->setQuery($q);
		$orderDetail = $db->loadObjectList();
		return $orderDetail;

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
		$product_attributes = $db->loadObjectList();
		return $product_attributes;
	}
	public function getProductInfo(){
			$app = JFactory::getApplication();
			$input = $app->input;
			$orderNumber=$input->get('orderNumber', '', 'string');
			$orderPass=$input->get('orderPass', '', 'string');
			$orderId = $this->getOrderIdByOrderPass($orderNumber,$orderPass);
			$product_attributes = $this->getOrderProductAttribute($orderId);
			$productInfos = array();
			$i=0;
			foreach($product_attributes as $product_attribute_object)
			{
				$product_attribute = $product_attribute_object->product_attribute;
				$productInfo = new stdClass();
				$productInfo->hasRoot =strpos($product_attribute,'Yes Roots')>0;
				$productInfo->ancestorLevel =3;
				$productInfo->descendantLevel = 3;

				$Ancestry4Couple = strpos($product_attribute,'Ancestry - 4 Generation Couple'); 
				$Ancestry4Individual = strpos($product_attribute,'Ancestry - 4 Generation Individual'); 
				$Ancestry5Individual = strpos($product_attribute,'Ancestry - 5 Generation Individual'); 
				$Descendant2 = strpos($product_attribute,'Descendant - 2 Generation'); 
				$Descendant3 = strpos($product_attribute,'Descendant - 3 Generation'); 
				$Descendant4 = strpos($product_attribute,'Descendant - 4 Generation'); 
				$Descendant5 = strpos($product_attribute,'Descendant - 5 Generation'); 
				 if($Ancestry4Couple)
				 {
				 	$productInfo->treeType = 'AncestorCouple';
				 	$productInfo->ancestorLevel = 4;
				 	$productInfo->productName ='Ancestry - 4 Generation Couple';
				 }
				 elseif($Ancestry4Individual){

				 	$productInfo->treeType = 'AncestorSingle';
				 	$productInfo->ancestorLevel =4;
				 	$productInfo->productName ='Ancestry - 4 Generation Individual';
				 }
				 elseif($Ancestry5Individual){

				 	$productInfo->treeType = 'AncestorSingle';
				 	$productInfo->ancestorLevel = 5;
				 	$productInfo->productName ='Ancestry - 5 Generation Individual';
				 }
				 elseif($Descendant2){

				 	$productInfo->treeType = 'Descendant';
				 	$productInfo->descendantLevel = 2;
				 	$productInfo->productName ='Descendant - 2 Generation';
				 }
				 elseif($Descendant3){

				 	$productInfo->treeType = 'Descendant';
				 	$productInfo->descendantLevel = 3;
				 	$productInfo->productName ='Descendant - 3 Generation';
				 }
				 elseif($Descendant4){

				 	$productInfo->treeType = 'Descendant';
				 	$productInfo->descendantLevel = 4;
				 	$productInfo->productName ='Descendant - 4 Generation';
				 }
				 elseif($Descendant5){
				 	$productInfo->treeType = 'Descendant';
				 	$productInfo->descendantLevel = 5;
				 	$productInfo->productName ='Descendant - 5 Generation';
				 }
				 array_push($productInfos,$productInfo);
			}
			return $productInfos;
	}
	public function getTreeData() {
		$app = JFactory::getApplication();
		$input = $app->input;
		$orderNumber=$input->get('orderNumber', '', 'string');
		$orderPass=$input->get('orderPass', '', 'string');

		$query="select Tree_Data from `#__familytree_tree_data` where Order_Number='$orderNumber' and Order_Pass ='$orderPass'";
		$db = JFactory::getDBO();
		$strTreeData = $db->setQuery($query)->loadResult();
		if($strTreeData===null || $strTreeData=='')
		{
			$productInfos =$this->getProductInfo();
			$treeDatas = array();
			foreach ($productInfos as $productInfo) {
				$treeData = new stdClass();
				$treeData->mainPersonData =null;
				$treeData->spouseData =null;
				$treeData->treeType = $productInfo->treeType;
				$treeData->hasRoot = $productInfo->hasRoot;
				$treeData->descendantLevel = $productInfo->descendantLevel;
				$treeData->ancestorLevel = $productInfo->ancestorLevel;
				$treeData->allowAddBirthDay=false;	
				$treeData->productName = $productInfo->productName; 
				array_push($treeDatas,$treeData);
			}			
			$strTreeData = json_encode($treeDatas);
		}
		return $strTreeData;
	}

	public function updateTreeData()
	{
		$app = JFactory::getApplication();
		$postData = $app->input->post;
		$orderNumber=$postData->get('orderNumber', '', 'string');
		$orderPass=$postData->get('orderPass', '', 'string');
		$treeData =$postData->get('treeData', '', 'string');
		$db = JFactory::getDBO();
		$encodeString = mysql_escape_string($treeData);
		$query="insert into `#__familytree_tree_data`(`Order_Number`,`Order_Pass`,`Tree_Data`) values('$orderNumber','$orderPass','$encodeString') ON DUPLICATE KEY UPDATE `Tree_Data`='$encodeString'";
		$result = $db->setQuery($query)->query();
		return $result;
	}
	
	public function sentEmail()
	{
		$app = JFactory::getApplication();
		$input = $app->input;
		$orderNumber=$input->get('orderNumber', '', 'string');
		$orderPass=$input->get('orderPass', '', 'string');
		$orderId = $this->getOrderIdByOrderPass($orderNumber,$orderPass);
		$orderDetail = $this->getOrder($orderId);

		$my_file = "emailTemplate.html";
		$attachment_my_file_name = $orderNumber."-family-tree.html";
		$my_path = $_SERVER['DOCUMENT_ROOT']."/components/com_familytree/js/";
		$my_name = "Custom Family Tree";
		$my_mail = $orderDetail[0]->order_email ;
		$my_replyto = $orderDetail[0]->order_email ;

		$productInfos =$this->getProductInfo();
		$productItemsName="";
		foreach ($productInfos as $productInfo) {
			$productItemsName = $productItemsName.$productInfo->productName." | ";
		}
		$productItemsName = rtrim($productItemsName," | ");
		$my_subject = "Order ".$orderNumber." - ".$orderDetail[0]->order_name;//This is a mail with attachment.";
		$date = date('m/d/Y h:i:s a', time());
		$my_message = $orderDetail[0]->order_name ." completed the "."[".$productItemsName."] Forms"." at ".$date.". Please see attached." //"Hello,\r\n This is family tree data of customer with customer info:"
		."\r\n Name: ".$orderDetail[0]->order_name 
		."\r\n Email: ".$orderDetail[0]->order_email 
		."\r\n Order Number:".$orderNumber 
		."\r\n\r\n --Custom Family Tree";
		$this->mail_attachment($my_file,$attachment_my_file_name, $my_path, "noelle@customfamilytreeart.com,huynp88@gmail.com", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
		return true;
	}


	function mail_attachment($filename,$attachment_my_file_name, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
		$treeData =$this->getTreeData();
		$stringToReplace = "<a id='temp-data' style='display:none' data-tree=\"".htmlentities($treeData)."\">Tree Data</a>";
	    $file = $path.$filename;
	    $file_size = filesize($file);
	    $handle = fopen($file, "r");
	    $content = fread($handle, $file_size);
		$content = str_replace("[data]",$stringToReplace, $content);
	    fclose($handle);
	    $content = chunk_split(base64_encode($content));
	    $uid = md5(uniqid(time()));
	    $header = "From: ".$from_name." <".$from_mail.">\r\n";
	    $header .= "BCC: huynp88@gmail.com\r\n";  
	    $header .= "Reply-To: ".$replyto."\r\n";
	    $header .= "MIME-Version: 1.0\r\n";
	    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	    $header .= "This is a multi-part message in MIME format.\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
	    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	    $header .= $message."\r\n\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-Type: application/octet-stream; name=\"".$attachment_my_file_name."\"\r\n"; // use different content types here
	    $header .= "Content-Transfer-Encoding: base64\r\n";
	    $header .= "Content-Disposition: attachment; filename=\"".$attachment_my_file_name."\"\r\n\r\n";
	    $header .= $content."\r\n\r\n";
	    $header .= "--".$uid."--";
	    if (mail($mailto, $subject, "", $header)) {
	        echo "mail send ... OK"; // or use booleans here
	    } else {
	        echo "mail send ... ERROR!";
	    }
	}

}
