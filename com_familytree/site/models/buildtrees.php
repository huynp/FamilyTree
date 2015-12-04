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
		$my_path = $_SERVER['DOCUMENT_ROOT']."/components/com_familytree/js/";
		$my_name = "Huy Nguyen";
		$my_mail = "huynp88@gmail.com";
		$my_replyto = "huynp88@gmail.com";
		$my_subject = "This is a mail with attachment.";
		$my_message = "Hello,\r\n This is family tree data of customer with customer info:"
		."\r\n Name: ".$orderDetail[0]->order_name 
		."\r\n Email: ".$orderDetail[0]->order_email 
		."\r\n Order Number:".$orderNumber 
		."\r\n\r\n --Custom Family Tree";
		$this->mail_attachment($my_file, $my_path, "huynp88@gmail.com", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
		return true;
	}


	function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
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
	    $header .= "Reply-To: ".$replyto."\r\n";
	    $header .= "MIME-Version: 1.0\r\n";
	    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	    $header .= "This is a multi-part message in MIME format.\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
	    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	    $header .= $message."\r\n\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
	    $header .= "Content-Transfer-Encoding: base64\r\n";
	    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
	    $header .= $content."\r\n\r\n";
	    $header .= "--".$uid."--";
	    if (mail($mailto, $subject, "", $header)) {
	        echo "mail send ... OK"; // or use booleans here
	    } else {
	        echo "mail send ... ERROR!";
	    }
	}

}
