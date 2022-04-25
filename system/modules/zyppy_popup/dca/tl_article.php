<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018-2022 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */

 

$GLOBALS['TL_DCA']['tl_article']['config']['onsubmit_callback'][] 	= array('ZyppyPopup\Backend\Article', 'checkSection');

 
/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace(';{syndication_legend}', ';{popup_legend},popup;{syndication_legend}', $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'popup';
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'popupAccept';

$GLOBALS['TL_DCA']['tl_article']['subpalettes']['popup'] 		= 'popupUuid,popupClass,popupDelay,popupReshowDelay,popupScrollTrigger,popupFadeDuration,popupTrigger,popupAddClose,popupAccept';
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['popupAccept'] 	= 'popupRejectUrl';
 
  
/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_article']['fields']['inColumn']['options_callback'] 	= array('ZyppyPopup\Backend\Article', 'getActiveLayoutSections');


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
		array('ZyppyPopup\Backend\Article', 'generateArticleUuid')
	),
	'sql'                     => "varchar(255) BINARY NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupClass'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupClass'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
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

$GLOBALS['TL_DCA']['tl_article']['fields']['popupAccept'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupAccept'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['popupRejectUrl'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['popupRejectUrl'],
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'addWizardClass'=>false, 'tl_class'=>'long clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);
