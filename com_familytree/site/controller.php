<?php

/**
 * Created by PhpStorm.
 * User: Phan Huy
 * Date: 10/18/2015
 * Time: 10:46 AM
 */
defined('_JEXEC') or die('Error you do not have perssion');
jimport('joomla.application.component.controller');
class FamilyTreeController extends JController{
	
	function display($cachable = false, $urlparams = false) 
	{
		echo "this is default action without task";
	}

	function familyTreeBuilder()
	{

		$app = JFactory::getApplication();
		$input = $app->input;
		$orderNumber=$input->get('orderNumber', '', 'string');
		$orderPass=$input->get('orderPass', '', 'string');
		$query="select Tree_Data from `#__familytree_tree_data` where Order_Number='$orderNumber' and Order_Pass ='$orderPass'";
		$db = JFactory::getDBO();
		$treeData = $db->setQuery($query)->loadResult();
		//load view
		$view = $this->getView( 'Create', 'html' );
		//$view->setLayout('modal');
		$view->display();
		/*echo '<form method="post" action="index.php?option=com_familytree&task=save">
			<input type="text"  value="'.$orderNumber.'" disabled />
			<input type="hidden" name="orderNumber" value="'.$orderNumber.'" />
			<input type="text" value="'.$orderPass.'"  disabled/>
			<input type="hidden" name="orderPass" value="'.$orderPass.'" />
			<textarea row="10" col="10" name="treeData">'.$treeData.'</textarea>
			<input type="submit" value="submit"/>
		</form>';*/
	}
	
	function save()
	{
		$app = JFactory::getApplication();
		$postData = $app->input->post;
		$orderNumber=$postData->get('orderNumber', '', 'string');
		$orderPass=$postData->get('orderPass', '', 'string');
		$treeData =$postData->get('treeData', '', 'string');
		$db = JFactory::getDBO();
		$query="insert into `#__familytree_tree_data`(`Order_Number`,`Order_Pass`,`Tree_Data`) values('$orderNumber','$orderPass','$treeData') ON DUPLICATE KEY UPDATE `Tree_Data`='$treeData'";
		$result = $db->setQuery($query)->query();
		echo '<div id="create">'.$result.'-'.$query.'-'.$orderNumber.'-'.$orderPass.'-'.$treeData.'</div>';
	
	}


	function delete()
	{
		$app= JFactory::getApplication();
		$id = JRequest::getVar("id");
		echo "you are delete ".$id;
		$app->close();
	}
}
