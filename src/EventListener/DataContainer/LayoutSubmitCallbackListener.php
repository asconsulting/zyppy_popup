<?php
 
/**
 * Zyppy Popup
 *
 * Copyright (C) 2018-2022 Andrew Stevens Consulting
 *
 * @package    asconsulting/zyppy_popup
 * @link       https://andrewstevens.consulting
 */



namespace ZyppyPopup\EventListener\DataContainer;


use Contao\ArticleModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database;
use Contao\DataContainer;
use Contao\StringUtil;

use Doctrine\DBAL\Connection;


#[AsCallback(table: 'tl_layout', target: 'config.onsubmit')]
class LayoutSubmitCallbackListener
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function __invoke(DataContainer $dc): void
    {
        if (!$dc->id) {
            return;
        }
		
		$objDatabase = Database::getInstance()->execute("SELECT id, sections FROM tl_layout WHERE sections NOT LIKE '?s:2:\"id\";s:5:\"popup\";?'");
		if ($objDatabase) {
			while ($objDatabase->next()) {
				$arrSections = StringUtil::deserialize($objDatabase->sections, true);
				if (!is_array($arrSections)) {
					$arrSections = array();
				}
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
						$arrSections[] = array('title'=>'Pop-up', 'id'=>'popup', 'template'=>'block_section', 'position'=>'bottom');
					}
					Database::getInstance()->prepare('UPDATE tl_layout SET sections=? WHERE id=?')->execute(serialize($arrSections), $objDatabase->id);
				}
			}
		}
		
    }

}
