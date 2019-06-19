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
 * Palettes
 */
foreach($GLOBALS['TL_DCA']['tl_module']['palettes'] as $key => $value) {
	$GLOBALS['TL_DCA']['tl_module']['palettes'][$key] = str_replace(',type', ',type;{popup_legend},popup', $value);
}	

if ($GLOBALS['TL_DCA']['tl_module']['palettes']['zyppy_search']) {
	$GLOBALS['TL_DCA']['tl_module']['palettes']['zyppy_search'] = str_replace(',disableAjax;', ',disableAjax,popupClear;', $GLOBALS['TL_DCA']['tl_module']['palettes']['zyppy_search']);
}
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'popup';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['popup'] = 'popupUuid,popupDelay,popupReshowDelay,popupScrollTrigger,popupFadeDuration,popupTrigger,popupAddClose';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['inColumn']['options_callback'] = array('Asc\Backend\ZyppyPopup', 'getActiveLayoutSections');

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
		array('Asc\Backend\ZyppyPopup', 'generateArticleUuid')
	),
	'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
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
