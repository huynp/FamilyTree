<?php

/**
 * @version     1.0.0
 * @package     com_familytree
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Huy <huynp88@gmail.com> - http://
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Familytree.
 */
class FamilyTreeViewBuildtrees extends JView {
    /**
     * Display the view
     */
    protected $modelData;
    protected $orderNumber;
    protected $orderPass;
    public function display($tpl = null) {
    	$app = JFactory::getApplication();
		$input = $app->input;
		$this->orderNumber = $input->get('orderNumber', '', 'string');
		$this->orderPass = $input->get('orderPass', '', 'string');
        $model = $this->getModel();
        $this->modelData = $model->getTreeData();
        parent::display($tpl);
    }


}