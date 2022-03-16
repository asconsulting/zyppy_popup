<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018-2022 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */

 
 
namespace ZyppyPopup\Backend;

use Contao\Backend as Contao_Backend;
use Contao\DataContainer;
use Contao\LayoutModel;
use Contao\PageModel;


class Article extends Contao_Backend
{
	
	
	public function loadArticle(DataContainer $dc) 
	{
		if ($dc->activeRecord->popup == 1) {
			$dc->activeRecord->inColumn = 'popup';
		} else {
			if ($dc->activeRecord->inColumn == 'popup') {
				$dc->activeRecord->inColumn = 'main';
			}
		}
	}


	public function saveArticle(DataContainer $dc) 
	{
		if ($dc->activeRecord->popup == 1) {
			$dc->activeRecord->inColumn = 'popup';
		} else {
			if ($dc->activeRecord->inColumn == 'popup') {
				$dc->activeRecord->inColumn = 'main';
			}
		}
	}
	
	
	public function checkSection($varValue, DataContainer $dc) 
	{
		if ($dc->activeRecord->popup == 1)
		{
			return 'popup';
		} else {
			if ($varValue == 'popup') {
				return 'main';
			}
			return $varValue;
		}
	}
	
	
	public function generateArticleUuid($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->popup) {
			$autoUuid = false;
	
			// Generate an alias if there is none
			if ($varValue == '')
			{
				$autoUuid = true;
				$varValue = uniqid('p');
			}
	
			$objUuid = $this->Database->prepare("SELECT id FROM tl_article WHERE popupUuid=?")
									   ->execute($dc->id, $varValue);
	
			if ($objUuid->numRows > 1)
			{
				$varValue .= '-' . $dc->id;
			}
	
			return $varValue;
		}
	}
	
	
	/**
	 * Return all active layout sections as array
	 *
	 * @param DataContainer $dc
	 *
	 * @return array
	 */
	public function getActiveLayoutSections(DataContainer $dc)
	{
		// Show only active sections
		if ($dc->activeRecord->pid)
		{
			$arrSections = array();
			$objPage = PageModel::findWithDetails($dc->activeRecord->pid);

			// Get the layout sections
			foreach (array('layout', 'mobileLayout') as $key)
			{
				if (!$objPage->$key)
				{
					continue;
				}

				$objLayout = LayoutModel::findByPk($objPage->$key);

				if ($objLayout === null)
				{
					continue;
				}

				$arrModules = \StringUtil::deserialize($objLayout->modules);

				if (empty($arrModules) || !\is_array($arrModules))
				{
					continue;
				}

				// Find all sections with an article module (see #6094)
				foreach ($arrModules as $arrModule)
				{
					if ($arrModule['mod'] == 0 && $arrModule['enable'])
					{
						$arrSections[] = $arrModule['col'];
					}
				}
			}
			$arrSections[] = 'popup';
		}

		// Show all sections (e.g. "override all" mode)
		else
		{
			$arrSections = array('header', 'left', 'right', 'main', 'footer', 'popup');
			$objLayout = $this->Database->query("SELECT sections FROM tl_layout WHERE sections!=''");

			while ($objLayout->next())
			{
				$arrCustom = \StringUtil::deserialize($objLayout->sections);

				// Add the custom layout sections
				if (!empty($arrCustom) && \is_array($arrCustom))
				{
					foreach ($arrCustom as $v)
					{
						if (!empty($v['id']))
						{
							$arrSections[] = $v['id'];
						}
					}
				}
			}
		}

		return Contao_Backend::convertLayoutSectionIdsToAssociativeArray($arrSections);
	}

}
