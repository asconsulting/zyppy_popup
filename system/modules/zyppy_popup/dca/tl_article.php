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
 * Config
 */
$GLOBALS['TL_DCA']['tl_article']['config']['onload_callback'][] = array('Asc\Backend\ZyppyPopup', 'loadArticle');
$GLOBALS['TL_DCA']['tl_article']['config']['onsubmit_callback'][] = array('Asc\Backend\ZyppyPopup', 'saveArticle');

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
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popup'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupUuid'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupUuid'],
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
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupDelay'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupReshowDelay'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupReshowDelay'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);
		
$GLOBALS['TL_DCA']['tl_article']['fields']['popupScrollTrigger'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupScrollTrigger'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupFadeDuration'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupFadeDuration'],
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupTrigger'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupTrigger'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupAddClose'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupAddClose'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);
