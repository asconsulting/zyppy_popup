<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018-2026 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */



namespace ZyppyPopup\EventListener\DataContainer;


use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database;
use Contao\DataContainer;


#[AsCallback(table: 'tl_module', target: 'fields.popupUuid.save')]
class ModulePopupUuidSaveCallback
{
    public function __invoke($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->popup) {
			$autoUuid = false;
	
			// Generate an alias if there is none
			if ($varValue == '')
			{
				$autoUuid = true;
				$varValue = uniqid('p');
			}
	
			$objUuid = Database::getInstance()->prepare("SELECT id FROM tl_module WHERE id!=? AND popupUuid=?")
									   ->execute($dc->id, $varValue);
	
			if ($objUuid->numRows > 1)
			{
				$varValue .= '-' . $dc->id;
			}
	
			return $varValue;
		}
	}
}
