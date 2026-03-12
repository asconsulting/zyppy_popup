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


use Contao\ArticleModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database;
use Contao\DataContainer;
use Contao\StringUtil;

use Doctrine\DBAL\Connection;


#[AsCallback(table: 'tl_article', target: 'config.onsubmit')]
class ArticleSubmitCallbackListener
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
		
		$objArticle = ArticleModel::findByPk($dc->id);
		if ($objArticle) {
			if ($objArticle->popup == '1' && $objArticle->inColumn != 'popup') {
				$objArticle->inColumn = 'popup';
				$objArticle->save();
			} elseif ($objArticle->popup != '1' && $objArticle->inColumn == 'popup') {
				$objArticle->inColumn = 'main';
				$objArticle->save();
			}	
		}
		
    }

}
