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
 * Front end modules
 */
$GLOBALS['FE_MOD']['careerCenter']['pk_careerCenterList']			= 'ModuleCareerCenterList';


/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['content']['pk_careerCenter'] = array
(
	'tables'     => array('tl_pk_careerCenter_archive', 'tl_pk_careerCenter_items'),
	'icon'       => 'system/modules/pk_careerCenter/html/icon.png',
);

/**
 * Permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'careerCenter';
$GLOBALS['TL_PERMISSIONS'][] = 'careerCenterp';

