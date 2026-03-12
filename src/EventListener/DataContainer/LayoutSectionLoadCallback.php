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


#[AsCallback(table: 'tl_layout', target: 'fields.section.load')]
class LayoutSectionLoadCallback
{
    public function __invoke($varValue, DataContainer $dc)
	{
		$arrSections = StringUtil::deserialize($varValue, true);
		$boolInject = true;
		foreach($arrSections as $intIndex => $arrSection) {
			if ($arrSection['id'] == 'popup') {
				$boolInject = false;
				if ($arrSection['title'] != 'Pop-up') {
					$arrSections[$intIndex]['title'] = 'Pop-up';
				}
			}
		}
		if ($boolInject) {
			if (count($arrSections) == 1 && $arrSections[0]['id'] == '') {
				$arrSections[0] = array('title'=>'Pop-up', 'id'=>'popup','template'=>'block_section','position'=>'bottom');
			} else {
				$arrSections[] = array('title'=>'Pop-up', 'id'=>'popup','template'=>'block_section','position'=>'bottom');
			}
		}
		return serialize($arrSections);
	}
}
