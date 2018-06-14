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
$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace(';{syndication_legend}', ';{popup_legend},popup;{syndication_legend}', $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'popup';
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['popup'] = 'popupUuid,popupDelay,popupReshowDelay,popupScrollTrigger,popupFadeDuration,popupTrigger,popupAddClose';
 
  
/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_article']['fields']['inColumn']['options_callback'] 	= array('Asc\Backend\ZyppyPopup', 'getActiveLayoutSections');
$GLOBALS['TL_DCA']['tl_article']['fields']['inColumn']['load_callback'][] 	= array('Asc\Backend\ZyppyPopup', 'loadLayoutSections');
$GLOBALS['TL_DCA']['tl_article']['fields']['inColumn']['save_callback'][]	= array('Asc\Backend\ZyppyPopup', 'saveLayoutSections');


$GLOBALS['TL_DCA']['tl_article']['fields']['popup'] = array(
	'exclude'                 => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popup'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupUuid'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupUuid'],
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

$GLOBALS['TL_DCA']['tl_article']['fields']['popupDelay'] = array
(
	'exclude'                 => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupDelay'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupReshowDelay'] = array
(
	'exclude'                 => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupReshowDelay'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);
		
$GLOBALS['TL_DCA']['tl_article']['fields']['popupScrollTrigger'] = array
(
	'exclude'                 => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupScrollTrigger'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupFadeDuration'] = array
(
	'exclude'                 => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupFadeDuration'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupTrigger'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupTrigger'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupAddClose'] = array(
	'exclude'                 => true,
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupAddClose'],
	'inputType'               => 'checkbox',
	'sql'                     => "char(1) NOT NULL default ''"
);
