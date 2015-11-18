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
	   parent::display($cachable, $urlparams);
        return $this;
	}

	function familyTreeBuilder()
	{

		
		$view = $this->getView( 'Buildtrees', 'html' );
	  	//$model = $this->getModel ( 'buildtrees' ); // get first model
	  	//$view->setModel( $model, true );  // true is for the default mode
	   	$view->display();
		/*echo '<form method="post" action="index.php?option=com_familytree&task=save">
			<input type="text"  value="'.$orderNumber.'" disabled />
			<input type="hidden" name="orderNumber" value="'.$orderNumber.'" />
			<input type="text" value="'.$orderPass.'"  disabled/>
			<input type="hidden" name="orderPass" value="'.$orderPass.'" />
			<textarea row="10" col="10" name="treeData">'.$treeData .'</textarea>
			<input type="submit" value="submit"/>
		</form>';*/
	}
	
	function save()
	{
		$model = $this->getModel ( 'buildtrees' );
		$result =$model->updateTreeData();
		//$db = JFactory::getDBO();
		//$query="insert into `#__familytree_tree_data`(`Order_Number`,`Order_Pass`,`Tree_Data`) values('$orderNumber','$orderPass','$treeData') ON DUPLICATE KEY UPDATE `Tree_Data`='$treeData'";
		//$result = $db->setQuery($query)->query();
		header('Content-Type: application/json');
		echo  $result;
	}


	function delete()
	{
		$app= JFactory::getApplication();
		$id = JRequest::getVar("id");
		echo "you are delete ".$id;
		$app->close();
	}
}
