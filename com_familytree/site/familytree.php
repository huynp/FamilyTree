<?php
/**
 * Created by PhpStorm.
 * User: Phan Huy
 * Date: 10/18/2015
 * Time: 10:58 AM
 */

defined('_JEXEC') or die('Error you do not have perssion');
jimport('joomla.application.component.controller');
ini_set("display_errors", "1");
error_reporting(E_ALL);
$doc = JFactory::getDocument();
$doc->addStyleSheet("components/com_familytree/css/frontend.css");
$doc->addScript("components/com_familytree/js/frontend.js");
		
$controller = JController::getInstance('FamilyTree');
$controller->execute(JRequest::getCmd('task'));

$controller->redirect();
?>