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
	   	$view->display();
	}
	
	function getTreeData()
	{

		$model = $this->getModel ( 'buildtrees' );
		$result =$model->getTreeData();
		echo $result;
	}
	
	function save()
	{
		$model = $this->getModel ( 'buildtrees' );
		$result =$model->updateTreeData();
		header('Content-Type: application/json');
		echo  $result;
	}


	
	function finish()
	{
		$model = $this->getModel ( 'buildtrees' );
		$result =$model->updateTreeData();
		$result = $model->sentEmail();
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
