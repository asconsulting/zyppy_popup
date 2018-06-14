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
	'Asc\Backend\ZyppyPopup' 			=> 'system/modules/zyppy_popup/library/Asc/Backend/ZyppyPopup.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'fe_popup_wrapper' 					=> 'system/modules/asc_directory/templates/frontend',
));