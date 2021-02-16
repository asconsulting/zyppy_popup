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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Asc\Backend\ZyppyPopup' 			=> 'system/modules/zyppy_popup/library/Asc/Backend/ZyppyPopup.php',
	'Asc\Frontend\PagePopup' 			=> 'system/modules/zyppy_popup/library/Asc/Frontend/PagePopup.php',
	'Asc\Widget\PopupModuleWizard' 		=> 'system/modules/zyppy_popup/library/Asc/Widget/PopupModuleWizard.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'fe_popup_wrapper' 					=> 'system/modules/zyppy_popup/templates/frontend',
	'mod_article' 						=> 'system/modules/zyppy_popup/templates/modules',
));
