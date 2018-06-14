<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */


namespace Asc\Module;

use Contao\ModuleArticle;
 
/**
 * Class Asc\Module\PopupArticle
 */
class PopupArticle extends ModuleArticle
{
	/**
	 * Generate the module
	 */
	protected function compile()
	{
		parent::compile();
		
		if ($this->popup) {
			if (!in_array('system/modules/zyppy_popup/assets/js/popup.js', $GLOBALS['TL_JAVASCRIPT'])) { 
				$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/zyppy_popup/assets/js/popup.js';
			}
			
			$strArticle = $this->Template->parse();
		
			$this->Template = new \FrontendTemplate('fe_popup_wrapper');
			$this->Template->popup = 1;
			$this->Template->popupUuid = $this->popupUuid;
			$this->Template->popupDelay = $this->popupDelay;
			$this->Template->popupReshowDelay = $this->popupReshowDelay;
			$this->Template->popupScrollTrigger = $this->popupScrollTrigger;
			$this->Template->popupFadeDuration = $this->popupFadeDuration;
			$this->Template->popupTrigger = $this->popupTrigger;
			$this->Template->popupAddClose = $this->popupAddClose;
			$this->Template->body = $strArticle;
		}
	}
}