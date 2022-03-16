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
 * Config
 */
$GLOBALS['TL_DCA']['tl_layout']['config']['onload_callback'][] = array('ZyppyPopup\Backend\Layout', 'injectSectionDatacontainer');
$GLOBALS['TL_DCA']['tl_layout']['config']['onsubmit_callback'][] = array('ZyppyPopup\Backend\Layout', 'injectSectionDatacontainer');


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_layout']['fields']['sections']['load_callback'][] = array('ZyppyPopup\Backend\Layout', 'injectPopupSection');
$GLOBALS['TL_DCA']['tl_layout']['fields']['sections']['save_callback'][] = array('ZyppyPopup\Backend\Layout', 'injectPopupSection');
$GLOBALS['TL_DCA']['tl_layout']['fields']['sections']['default'] = 'a:1:{i:0;a:4:{s:5:"title";s:6:"Pop-up";s:2:"id";s:5:"popup";s:8:"template";s:13:"block_section";s:8:"position";s:6:"bottom";}}';
$GLOBALS['TL_DCA']['tl_layout']['fields']['sections']['eval']['submitOnChange'] = true;
