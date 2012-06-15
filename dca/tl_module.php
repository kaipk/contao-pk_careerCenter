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
 * Add palettes to tl_module
 */ 
$GLOBALS['TL_DCA']['tl_module']['palettes']['pk_careerCenterList']    = '{title_legend},name,headline;{config_legend},careerCenter_archives,jobs_numberOfItems,perPage;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
 
 
/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['careerCenter_archives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['careerCenter_archives'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_module_careerCenter', 'getArchives'),
	'eval'                    => array('submitOnChange'=>true,'multiple'=>true, 'mandatory'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['jobs_numberOfItems'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['jobs_numberOfItems'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50')
);


/**
 * Class tl_module_careerCenter
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Philipp Kaiblinger 2012
 * @author     Philipp Kaiblinger <http://www.kaipo.at>
 * @package    Controller
 */
class tl_module_careerCenter extends Backend
{
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Get all product archives and return them as array
	 * @return array
	 */
	public function getArchives()
	{
		
		if (!$this->User->isAdmin && !is_array($this->User->careerCenter))
		{
			return array();
		}

		$arrArchives = array();
		$objArchives = $this->Database->execute("SELECT id, title FROM tl_pk_careerCenter_archive ORDER BY title");

		while ($objArchives->next())
		{
			if ($this->User->isAdmin || $this->User->hasAccess($objArchives->id, 'careerCenter'))
			{
				$arrArchives[$objArchives->id] = $objArchives->title;
			}
		}

		return $arrArchives;
	}
}

?>