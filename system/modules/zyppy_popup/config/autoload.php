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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ZyppyPopup\Backend\Article' 				=> 'system/modules/zyppy_popup/library/ZyppyPopup/Backend/Article.php',
	'ZyppyPopup\Backend\Layout' 				=> 'system/modules/zyppy_popup/library/ZyppyPopup/Backend/Layout.php',
	'ZyppyPopup\Backend\Module' 				=> 'system/modules/zyppy_popup/library/ZyppyPopup/Backend/Module.php',
	
	'ZyppyPopup\Frontend\Page' 					=> 'system/modules/zyppy_popup/library/ZyppyPopup/Frontend/Page.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'fe_popup_wrapper' 					=> 'system/modules/zyppy_popup/templates/frontend',
	'mod_article' 						=> 'system/modules/zyppy_popup/templates/modules',
));
