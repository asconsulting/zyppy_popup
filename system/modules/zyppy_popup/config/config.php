<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */
 
 
/**
 * Pages
 */ 
$GLOBALS['TL_PTY']['regular'] = 'Asc\Frontend\PagePopup';
	
	
/**
 * Widgets
 */ 
$GLOBALS['BE_FFL']['moduleWizard'] = 'Asc\Widget\PopupModuleWizard';

/**
 * Styles
 */
 if (version_compare(VERSION, '4.4', '>=')) {
	$GLOBALS['TL_CSS'][] = 'system/modules/zyppy_popup/assets/css/backend-contao4.css|static';
}