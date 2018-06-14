<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */

 
namespace Asc\Frontend;

use Contao\PageRegular;


class PagePopup extends PageRegular
{
	
	/**
	 * Generate a regular page
	 *
	 * @param PageModel $objPage
	 *
	 * @internal Do not call this method in your code. It will be made private in Contao 5.0.
	 */
	protected function prepare($objPage)
	{
		$GLOBALS['TL_KEYWORDS'] = '';
		$GLOBALS['TL_LANGUAGE'] = $objPage->language;

		$locale = str_replace('-', '_', $objPage->language);
		\System::getContainer()->get('request_stack')->getCurrentRequest()->setLocale($locale);
		\System::getContainer()->get('translator')->setLocale($locale);

		\System::loadLanguageFile('default');

		// Static URLs
		$this->setStaticUrls();

		// Get the page layout
		$objLayout = $this->getPageLayout($objPage);

		// HOOK: modify the page or layout object (see #4736)
		if (isset($GLOBALS['TL_HOOKS']['getPageLayout']) && \is_array($GLOBALS['TL_HOOKS']['getPageLayout']))
		{
			foreach ($GLOBALS['TL_HOOKS']['getPageLayout'] as $callback)
			{
				$this->import($callback[0]);
				$this->{$callback[0]}->{$callback[1]}($objPage, $objLayout, $this);
			}
		}

		/** @var ThemeModel $objTheme */
		$objTheme = $objLayout->getRelated('pid');

		// Set the default image densities
		\System::getContainer()->get('contao.image.picture_factory')->setDefaultDensities($objTheme->defaultImageDensities);

		// Store the layout ID
		$objPage->layoutId = $objLayout->id;

		// Set the layout template and template group
		$objPage->template = $objLayout->template ?: 'fe_page';
		$objPage->templateGroup = $objTheme->templates;

		// Store the output format
		list($strFormat, $strVariant) = explode('_', $objLayout->doctype);
		$objPage->outputFormat = $strFormat;
		$objPage->outputVariant = $strVariant;

		// Initialize the template
		$this->createTemplate($objPage, $objLayout);

		// Initialize modules and sections
		$arrCustomSections = array();
		$arrSections = array('header', 'left', 'right', 'main', 'footer', 'popup');
		$arrModules = \StringUtil::deserialize($objLayout->modules);

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
		$objModules = \ModuleModel::findMultipleByIds($arrModuleIds);

		if ($objModules !== null || $arrModules[0]['mod'] == 0) // see #4137
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
				if (!$arrModule['enable'])
				{
					continue;
				}

				// Replace the module ID with the module model
				if ($arrModule['mod'] > 0 && isset($arrMapper[$arrModule['mod']]))
				{
					$arrModule['mod'] = $arrMapper[$arrModule['mod']];
				}
var_dump($arrModule);
echo "<br><hr><br><br>";
				// Generate the modules
				if (\in_array($arrModule['col'], $arrSections) && $arrModule['col'] != 'popup')
				{
					// Filter active sections (see #3273)
					if ($arrModule['col'] == 'header' && $objLayout->rows != '2rwh' && $objLayout->rows != '3rw')
					{
						continue;
					}
					if ($arrModule['col'] == 'left' && $objLayout->cols != '2cll' && $objLayout->cols != '3cl')
					{
						continue;
					}
					if ($arrModule['col'] == 'right' && $objLayout->cols != '2clr' && $objLayout->cols != '3cl')
					{
						continue;
					}
					if ($arrModule['col'] == 'footer' && $objLayout->rows != '2rwf' && $objLayout->rows != '3rw')
					{
						continue;
					}

					$this->Template->{$arrModule['col']} .= $this->getFrontendModule($arrModule['mod'], $arrModule['col']);
				}
				else
				{
					if ($arrModule['mod']->popup) {
						echo "<h4>Module</h4>";
						var_dump($arrModule['mod']);
						echo "<br><br>";
						$objPopupWrapperTemplate = new \FrontendTemplate('fe_popup_wrapper');
						$objPopupWrapperTemplate->popup = 1;
						$objPopupWrapperTemplate->popupUuid = $arrModule['mod']->popupUuid;
						$objPopupWrapperTemplate->popupDelay = $arrModule['mod']->popupDelay;
						$objPopupWrapperTemplate->popupReshowDelay = $arrModule['mod']->popupReshowDelay;
						$objPopupWrapperTemplate->popupScrollTrigger = $arrModule['mod']->popupScrollTrigger;
						$objPopupWrapperTemplate->popupFadeDuration = $arrModule['mod']->popupFadeDuration;
						$objPopupWrapperTemplate->popupTrigger = $arrModule['mod']->popupTrigger;
						$objPopupWrapperTemplate->popupAddClose = $arrModule['mod']->popupAddClose;
						$objPopupWrapperTemplate->body = $this->getFrontendModule($arrModule['mod'], $arrModule['col']);
						
						echo "<h4>Template</h4>";
						var_dump($objPopupWrapperTemplate);
						echo "<br><br>";
						
						//$arrCustomSections[$arrModule['col']] .= $objPopupWrapperTemplate->parse();
						//$arrCustomSections['main'] .= $objPopupWrapperTemplate->parse();
					}
					$arrCustomSections[$arrModule['col']] .= $this->getFrontendModule($arrModule['mod'], $arrModule['col']);
				}
			}
		}

		$this->Template->sections = $arrCustomSections;

		// Mark RTL languages (see #7171)
		if ($GLOBALS['TL_LANG']['MSC']['textDirection'] == 'rtl')
		{
			$this->Template->isRTL = true;
		}

		// HOOK: modify the page or layout object
		if (isset($GLOBALS['TL_HOOKS']['generatePage']) && \is_array($GLOBALS['TL_HOOKS']['generatePage']))
		{
			foreach ($GLOBALS['TL_HOOKS']['generatePage'] as $callback)
			{
				$this->import($callback[0]);
				$this->{$callback[0]}->{$callback[1]}($objPage, $objLayout, $this);
			}
		}

		// Set the page title and description AFTER the modules have been generated
		$this->Template->mainTitle = $objPage->rootPageTitle;
		$this->Template->pageTitle = $objPage->pageTitle ?: $objPage->title;

		// Meta robots tag
		$this->Template->robots = $objPage->robots ?: 'index,follow';

		// Remove shy-entities (see #2709)
		$this->Template->mainTitle = str_replace('[-]', '', $this->Template->mainTitle);
		$this->Template->pageTitle = str_replace('[-]', '', $this->Template->pageTitle);

		// Fall back to the default title tag
		if ($objLayout->titleTag == '')
		{
			$objLayout->titleTag = '{{page::pageTitle}} - {{page::rootPageTitle}}';
		}

		// Assign the title and description
		$this->Template->title = \StringUtil::stripInsertTags($this->replaceInsertTags($objLayout->titleTag)); // see #7097
		$this->Template->description = str_replace(array("\n", "\r", '"'), array(' ', '', ''), $objPage->description);

		// Body onload and body classes
		$this->Template->onload = trim($objLayout->onload);
		$this->Template->class = trim($objLayout->cssClass . ' ' . $objPage->cssClass);

		// Execute AFTER the modules have been generated and create footer scripts first
		$this->createFooterScripts($objLayout);
		$this->createHeaderScripts($objPage, $objLayout);
	}
	
}