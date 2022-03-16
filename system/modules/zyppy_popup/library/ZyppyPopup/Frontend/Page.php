<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018-2022 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */

 
 
namespace ZyppyPopup\Frontend;

use Contao\Frontend as Contao_Frontend;
use Contao\FrontendTemplate;
use Contao\ModuleModel;
use Contao\PageRegular;
use Contao\StringUtil;
use Contao\System;


class Page extends Contao_Frontend
{
	
	public function generatePage(&$objPageModel, $objLayout, &$objPage)
	{
		
		$objLayout = $objPage->getPageLayout($objPageModel);
		
		// Initialize modules and sections
		$arrCustomSections = array();
		$arrSections = array('header', 'left', 'right', 'main', 'footer');
		$arrModules = StringUtil::deserialize($objLayout->modules);

		$arrModuleIds = array();

		// Filter the disabled modules
		foreach ($arrModules as $module)
		{
			if ($module['enable'])
			{
				$arrModuleIds[] = $module['mod'];
			}
		}
		// Get all modules in a single DB query
		$objModules = ModuleModel::findMultipleByIds($arrModuleIds);

		if ($objModules !== null || \in_array(0, $arrModuleIds))
		{
			$arrMapper = array();

			// Create a mapper array in case a module is included more than once (see #4849)
			if ($objModules !== null)
			{
				while ($objModules->next())
				{
					$arrMapper[$objModules->id] = $objModules->current();
				}
			}

			foreach ($arrModules as $arrModule)
			{
				// Disabled module
				if (!BE_USER_LOGGED_IN && !$arrModule['enable'])
				{
					continue;
				}

				// Replace the module ID with the module model
				if ($arrModule['mod'] > 0 && isset($arrMapper[$arrModule['mod']]))
				{
					$arrModule['mod'] = $arrMapper[$arrModule['mod']];
				}

				// Generate the modules
				if (\in_array($arrModule['col'], $arrSections))
				{
					// Filter active sections (see #3273)
					if ($objLayout->rows != '2rwh' && $objLayout->rows != '3rw' && $arrModule['col'] == 'header')
					{
						continue;
					}

					if ($objLayout->cols != '2cll' && $objLayout->cols != '3cl' && $arrModule['col'] == 'left')
					{
						continue;
					}

					if ($objLayout->cols != '2clr' && $objLayout->cols != '3cl' && $arrModule['col'] == 'right')
					{
						continue;
					}

					if ($objLayout->rows != '2rwf' && $objLayout->rows != '3rw' && $arrModule['col'] == 'footer')
					{
						continue;
					}

					$objPage->Template->{$arrModule['col']} .= $objPage->getFrontendModule($arrModule['mod'], $arrModule['col']);
				}
				else
				{
					if ($arrModule['mod']->popup) {
						if ($arrModule['mod']->popupAccept) {
							if (!in_array('system/modules/zyppy_popup/assets/js/popup_accept.js', $GLOBALS['TL_JAVASCRIPT'])) { 
								$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/zyppy_popup/assets/js/popup_accept.js';
							}
						} else {
							if (!in_array('system/modules/zyppy_popup/assets/js/popup.js', $GLOBALS['TL_JAVASCRIPT'])) { 
								$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/zyppy_popup/assets/js/popup.js';
							}
						}
						
						$objPopupWrapperTemplate = new FrontendTemplate('fe_popup_wrapper');
						$objPopupWrapperTemplate->popup = 1;
						$objPopupWrapperTemplate->popupUuid = $arrModule['mod']->popupUuid;
						$objPopupWrapperTemplate->popupDelay = $arrModule['mod']->popupDelay;
						$objPopupWrapperTemplate->popupReshowDelay = $arrModule['mod']->popupReshowDelay;
						$objPopupWrapperTemplate->popupScrollTrigger = $arrModule['mod']->popupScrollTrigger;
						$objPopupWrapperTemplate->popupFadeDuration = $arrModule['mod']->popupFadeDuration;
						$objPopupWrapperTemplate->popupTrigger = $arrModule['mod']->popupTrigger;
						$objPopupWrapperTemplate->popupAddClose = $arrModule['mod']->popupAddClose;
						$objPopupWrapperTemplate->popupRejectUrl = $arrModule['mod']->popupRejectUrl;
						$objPopupWrapperTemplate->body = $objPage->getFrontendModule($arrModule['mod'], $arrModule['col']);
						
						$arrCustomSections[$arrModule['col']] .= $objPopupWrapperTemplate->parse();
						$arrCustomSections['main'] .= $objPopupWrapperTemplate->parse();
					} else {
						$arrCustomSections[$arrModule['col']] .= $objPage->getFrontendModule($arrModule['mod'], $arrModule['col']);
					}
				}
			}
		}

		$objPage->Template->sections = $arrCustomSections;
	}
	
}