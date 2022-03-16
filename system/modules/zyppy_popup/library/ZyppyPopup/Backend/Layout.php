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
use Contao\StringUtil;

class Layout extends Contao_Backend
{

	public function injectSectionDatacontainer(DataContainer $dc)
	{
		if ($dc->activeRecord->sections) {
			$arrSections = StringUtil::deserialize($dc->activeRecord->sections);
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
				$arrSections[] = array('title'=>'Pop-up', 'id'=>'popup','template'=>'block_section','position'=>'top');
			}
			$dc->activeRecord->sections = serialize($arrSections);
		} else {
			$dc->activeRecord->sections = 'a:1:{i:0;a:4:{s:5:"title";s:6:"Pop-up";s:2:"id";s:5:"popup";s:8:"template";s:13:"block_section";s:8:"position";s:3:"top";}}';
		}
	}

	public function injectSections($varValue, DataContainer $dc)
	{
		$arrSections = StringUtil::deserialize($varValue);
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
			$arrSections[] = array('title'=>'Pop-up', 'id'=>'popup','template'=>'block_section','position'=>'top');
		}
		return serialize($arrSections);
	}

}