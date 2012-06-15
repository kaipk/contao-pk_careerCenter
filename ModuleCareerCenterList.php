<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *
 * PHP version 5
 * @copyright  KAIPO EDV IT Ges.m.b.H 2012
 * @author     Philipp Kaiblinger <philipp.kaiblinger@kaipo.at>
 * @package    jobListing
 * @license    LGPL
 * @version    $Id:
 */
 
 /**
 * Class ModuleCareerCenterList
 *
 * Front end module "job list".
 * @copyright  Philipp Kaiblinger 2012
 * @author     Philipp Kaiblinger <http://www.kaipo.at>
 * @package    Controller
 */
class ModuleCareerCenterList extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_jobslist';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### JOBS LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		
		$this->careerCenter_archives = deserialize($this->careerCenter_archives);
		
		// Return if there are no archives
		if (!is_array($this->careerCenter_archives) || empty($this->careerCenter_archives))
		{
			return '';
		}
	
		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;
		
		$time = time();
		$limit = null;
		$offset = 0;
		
		// Maximum number of items
		if ($this->jobs_numberOfItems > 0)
		{
			$limit = $this->jobs_numberOfItems;
		}
			
		// Get the total number of items
		$objTotal = $this->Database->execute("SELECT COUNT(*) AS total FROM tl_pk_careerCenter_items WHERE pid IN(" . implode(',', array_map('intval', $this->careerCenter_archives)) . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : ""));
		$total = $objTotal->total;
		
		// Split the results
		if ($this->perPage > 0 && (!isset($limit) || $this->jobs_numberOfItems > $this->perPage))
		{
			// Adjust the overall limit
			if (isset($limit))
			{
				$total = min($limit, $total);
			}

			// Get the current page
			$page = $this->Input->get('page') ? $this->Input->get('page') : 1;
			// Do not index or cache the page if the page number is outside the range
			if ($page < 1 || $page > ceil($total/$this->perPage))
			{
				global $objPage;
				$objPage->noSearch = 1;
				$objPage->cache = 0;

				// Send a 404 header
				header('HTTP/1.1 404 Not Found');
				return;
			}

			// Set limit and offset
			$limit = $this->perPage;
			$offset = (max($page, 1) - 1) * $this->perPage;

			// Overall limit
			if ($offset + $limit > $total)
			{
				$limit = $total - $offset;
			}

			// Add the pagination menu
			$objPagination = new Pagination($total, $this->perPage);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}

		$objArticlesStmt = $this->Database->prepare("SELECT *, (SELECT title FROM tl_pk_careerCenter_archive WHERE tl_pk_careerCenter_archive.id=tl_pk_careerCenter_items.pid) AS archive FROM tl_pk_careerCenter_items WHERE pid IN(" . implode(',', array_map('intval', $this->careerCenter_archives)) . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY date DESC");

		// Limit the result
		if (isset($limit))
		{
			$objArticlesStmt->limit($limit, $offset + $skipFirst);
		}
		elseif ($skipFirst > 0)
		{
			$objArticlesStmt->limit(max($total, 1), $skipFirst);
		}

		$objArticles = $objArticlesStmt->execute();

		// No items found
		if ($objArticles->numRows < 1)
		{
			$this->Template = new FrontendTemplate('mod_jobslistarchive_empty');
		}
		
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyjobList'];
		$this->Template->archives = $this->careerCenter_archives;
		
		$arrJobs = array();
		$i = 0;
		while ($objArticles->next())
		{
			$class = 'row_' . $i . (($i == 0) ? ' row_first' : '') . ((($i + 1) == $total) ? ' row_last' : '') . ((($i % 2) == 0) ? ' even' : ' odd');
			
			$arrJobs[$class] = array
			(
				'date' => $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objArticles->date),
				'title' => $objArticles->title,
				'company' => $objArticles->company,
				'city' => $objArticles->city,
				'enclosure' => $objArticles->enclosure
			);
			
			$i++;
		}
		
		$this->Template->jobs = $arrJobs;
		
	}
}

?>