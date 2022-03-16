<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018-2022 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */

 
 
/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['generatePage'][] 		= array('ZyppyClass\Frontend\Page', 'generatePage');
	
	
/**
 * Widgets
 */ 
//$GLOBALS['BE_FFL']['moduleWizard'] = 'ZyppyPopup\Widget\PopupModuleWizard';
