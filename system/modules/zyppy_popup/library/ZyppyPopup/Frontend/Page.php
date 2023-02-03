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
use Contao\LayoutModel;
use Contao\ModuleModel;
use Contao\PageRegular;
use Contao\StringUtil;
use Contao\System;


class Page extends Contao_Frontend
{
	
	public function generatePage(&$objPageModel, $objLayout, &$objPage)
	{
		
		$objLayout = $this->getPageLayout($objPageModel);
		
		// Initialize modules and sections
		$arrCustomSections = $objPage->Template->sections;
		$arrCustomSections['popup'] = ''; // Unset the Popup section because we are going to regenerate it with the propper wrappers.
		$arrModules = StringUtil::deserialize($objLayout->modules, true);

		$arrModuleIds = array();

		// Filter the disabled modules
		foreach ($arrModules as $module)
		{
			if (array_key_exists('enable', $module) && $module['enable'])
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
				if (!BE_USER_LOGGED_IN && (!array_key_exists('enable', $arrModule) || !$arrModule['enable']))
				{
					continue;
				}

				// Replace the module ID with the module model
				if ($arrModule['mod'] > 0 && isset($arrMapper[$arrModule['mod']]))
				{
					$arrModule['mod'] = $arrMapper[$arrModule['mod']];
				}

				// Filter active sections (see #3273)
				if ($arrModule['col'] == 'popup')
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
						$objPopupWrapperTemplate->popupClass = $arrModule['mod']->popupClass;
						$objPopupWrapperTemplate->popupDelay = $arrModule['mod']->popupDelay;
						$objPopupWrapperTemplate->popupReshowDelay = $arrModule['mod']->popupReshowDelay;
						$objPopupWrapperTemplate->popupScrollTrigger = $arrModule['mod']->popupScrollTrigger;
						$objPopupWrapperTemplate->popupFadeDuration = $arrModule['mod']->popupFadeDuration;
						$objPopupWrapperTemplate->popupTrigger = $arrModule['mod']->popupTrigger;
						$objPopupWrapperTemplate->popupAddClose = $arrModule['mod']->popupAddClose;
						$objPopupWrapperTemplate->popupRejectUrl = $arrModule['mod']->popupRejectUrl;
						$objPopupWrapperTemplate->body = $objPage->getFrontendModule($arrModule['mod'], $arrModule['col']);
						
						$arrCustomSections['popup'] .= $objPopupWrapperTemplate->parse();
					} else {
						$arrCustomSections['popup'] .= $objPage->getFrontendModule($arrModule['mod'], $arrModule['col']);
					}
				}

			}
		}

		$objPage->Template->sections = $arrCustomSections;
	}
	
	
	/**
	 * Get a page layout and return it as database result object
	 *
	 * @param PageModel $objPage
	 *
	 * @return LayoutModel
	 */
	protected function getPageLayout($objPage)
	{
		$objLayout = LayoutModel::findByPk($objPage->layout);

		// Die if there is no layout
		if (null === $objLayout)
		{
			$this->log('Could not find layout ID "' . $objPage->layout . '"', __METHOD__, ContaoContext::ERROR);

			throw new NoLayoutSpecifiedException('No layout specified');
		}

		$objPage->hasJQuery = $objLayout->addJQuery;
		$objPage->hasMooTools = $objLayout->addMooTools;

		// HOOK: modify the page or layout object (see #4736)
		if (isset($GLOBALS['TL_HOOKS']['getPageLayout']) && \is_array($GLOBALS['TL_HOOKS']['getPageLayout']))
		{
			foreach ($GLOBALS['TL_HOOKS']['getPageLayout'] as $callback)
			{
				$this->import($callback[0]);
				$this->{$callback[0]}->{$callback[1]}($objPage, $objLayout, $this);
			}
		}

		return $objLayout;
	}
	
}
