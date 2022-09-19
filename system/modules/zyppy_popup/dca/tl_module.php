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
 * Palettes
 */
foreach($GLOBALS['TL_DCA']['tl_module']['palettes'] as $key => $value) {
	$GLOBALS['TL_DCA']['tl_module']['palettes'][$key] = str_replace(',type', ',type;{popup_legend},popup', $value);
}	

if (array_key_exists('zyppy_search', $GLOBALS['TL_DCA']['tl_module']['palettes'])) {
	$GLOBALS['TL_DCA']['tl_module']['palettes']['zyppy_search'] = str_replace(',disableAjax;', ',disableAjax,popupClear;', $GLOBALS['TL_DCA']['tl_module']['palettes']['zyppy_search']);
}
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'popup';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'popupAccept';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['popup'] = 'popupUuid,popupClass,popupDelay,popupReshowDelay,popupScrollTrigger,popupFadeDuration,popupTrigger,popupAddClose,popupAccept';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['popupAccept'] 	= 'popupRejectUrl';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['inColumn']['options_callback'] = array('ZyppyPopup\Backend\Module', 'getActiveLayoutSections');

$GLOBALS['TL_DCA']['tl_module']['fields']['popup'] = array(
	'filter'				  => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popup'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupUuid'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupUuid'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
	'save_callback' => array
	(
		array('ZyppyPopup\Backend\Module', 'generateModuleUuid')
	),
	'sql'                     => "varchar(255) BINARY NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupClass'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupClass'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupDelay'] = array
(
	'filter'				  => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupDelay'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupReshowDelay'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupReshowDelay'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);
		
$GLOBALS['TL_DCA']['tl_module']['fields']['popupScrollTrigger'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupScrollTrigger'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupFadeDuration'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupFadeDuration'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupTrigger'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupTrigger'],
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupAddClose'] = array(
	'exclude'                 => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupAddClose'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupClear'] = array(
	'exclude'                 => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupClear'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupAccept'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupAccept'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['popupRejectUrl'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['popupRejectUrl'],
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'addWizardClass'=>false, 'tl_class'=>'long clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);
