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
		JToolbarHelper::Title('Family Tree','family-tree');
		echo "Back end this is default action without task";
	}

	function create()
	{
		JToolbarHelper::Title('Family Tree Create','family-tree-create');
		echo '<div id="create">welcome back end - create page</div>';
	}
	function listFamilyTree()
	{
		JToolbarHelper::Title('Family Tree List','family-tree-list');
		echo 'Back end list family tree';
	}
	function delete()
	{
		$app= JFactory::getApplication();
		$id = JRequest::getVar("id");
		echo 'Back end delete'.$id;
		$app->close();
	}
}
?>