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
 * Hooks
 */
$GLOBALS['TL_HOOKS']['generatePage'][] 		= array('ZyppyPopup\Frontend\Page', 'generatePage');
