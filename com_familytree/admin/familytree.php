<?php
/**
 * Created by PhpStorm.
 * User: Phan Huy
 * Date: 10/18/2015
 * Time: 10:58 AM
 */

defined('_JEXEC') or die('Error you do not have perssion');
jimport('joomla.application.component.controller');

$doc = JFactory::getDocument();
$doc->addStyleSheet("components/com_familytree/css/backend.css");
$doc->addScript("components/com_familytree/js/backend.js");

$controller = JController::getInstance('FamilyTree');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
?>