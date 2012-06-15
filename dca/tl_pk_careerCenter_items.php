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
 * Table tl_pk_careerCenter_items
 */
$GLOBALS['TL_DCA']['tl_pk_careerCenter_items'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_pk_careerCenter_archive',
		'enableVersioning'            => true,
		'onload_callback' => array
		(
			array('tl_pk_careerCenter_items', 'checkPermission'),
		),
		'onsubmit_callback' => array
		(
			array('tl_pk_careerCenter_items', 'adjustTime'),
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('date DESC'),
			'headerFields'            => array('title', 'tstamp'),
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_pk_careerCenter_items', 'listCareerCenterArticles')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['copy'],
				'href'                => 'act=paste&mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['cut'],
				'href'                => 'act=paste&mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_pk_careerCenter_items', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	
// Palettes
	'palettes' => array
	(
		'__selector__'                => array('addEnclosure'),
		'default'					  => '{job_legend},title,company,city;{date_legend},date,time;{enclosure_legend:hide},addEnclosure;{expert_legend:hide},cssClass;{publish_legend},published,start,stop'
	
	),
	
	// Subpalettes
	'subpalettes' => array
	(
		'addEnclosure'                => 'enclosure',
		
	),
	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => false,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'company' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['company'],
			'exclude'                 => true,
			'search'                  => true,
			'flag'                    => 1,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'w50')
		),
		'city' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['city'],
			'exclude'                 => true,
			'search'                  => true,
			'flag'                    => 1,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'w50')
		),
		'date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['date'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'time' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['time'],
			'default'                 => time(),
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'time', 'tl_class'=>'w50')
		),
		'addEnclosure' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['addEnclosure'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'enclosure' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['enclosure'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>true)
		),
		'cssClass' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['cssClass'],
			'exclude'                 => true,
			'inputType'               => 'text'
		),		
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pk_careerCenter_items']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		)
	)
);


/**
 * Class tl_pk_careerCenter_items
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Philipp Kaiblinger 2012
 * @author     Philipp Kaiblinger <philipp.kaiblinger@kaipo.at>
 * @package    Controller
 */
class tl_pk_careerCenter_items extends Backend
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
	 * Check permissions to edit table tl_pk_careerCenter_items
	 */
	public function checkPermission()
	{
		if ($this->User->isAdmin)
		{
			return;
		}

		// Set root IDs
		if (!is_array($this->User->careerCenter) || count($this->User->careerCenter) < 1)
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->careerCenter;
		}

		$id = strlen($this->Input->get('id')) ? $this->Input->get('id') : CURRENT_ID;

		// Check current action
		switch ($this->Input->get('act'))
		{
			case 'paste':
				// Allow
				break;

			case 'create':
				if (!strlen($this->Input->get('pid')) || !in_array($this->Input->get('pid'), $root))
				{
					$this->log('Not enough permissions to create items in Career-Center archive ID "'.$this->Input->get('pid').'"', 'tl_pk_careerCenter_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'cut':
			case 'copy':
				if (!in_array($this->Input->get('pid'), $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' item ID "'.$id.'" to Career-Center archive ID "'.$this->Input->get('pid').'"', 'tl_pk_careerCenter_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				// NO BREAK STATEMENT HERE

			case 'edit':
			case 'show':
			case 'delete':
			case 'toggle':
				$objCareerCenter = $this->Database->prepare("SELECT pid FROM tl_pk_careerCenter_items WHERE id=?")
											  ->limit(1)
											  ->execute($id);

				if ($objCareerCenter->numRows < 1)
				{
					$this->log('Invalid job ID "'.$id.'"', 'tl_pk_career_center checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				if (!in_array($objCareerCenter->pid, $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' job ID "'.$id.'" of job archive ID "'.$objCareerCenter->pid.'"', 'tl_pk_careerCenter_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
			
			case 'select':
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
			case 'cutAll':
			case 'copyAll':
				if (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access Career-Center archive ID "'.$id.'"', 'tl_pk_careerCenter_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$objArchive = $this->Database->prepare("SELECT id FROM tl_pk_careerCenter_items WHERE pid=?")
											 ->execute($id);

				if ($objArchive->numRows < 1)
				{
					$this->log('Invalid Career-Center archive ID "'.$id.'"', 'tl_pk_careerCenter_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$session = $this->Session->getData();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objArchive->fetchEach('id'));
				$this->Session->setData($session);
				break;

			default:
				if (strlen($this->Input->get('act')))
				{
					$this->log('Invalid command "'.$this->Input->get('act').'"', 'tl_pk_careerCenter_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				elseif (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access Career-Center archive ID "'.$id.'"', 'tl_pk_careerCenter_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
	}
	
	
	/**
	 * Add the type of input field
	 * @param array
	 * @return string
	 */
	public function listCareerCenterArticles($arrRow)
	{
		$time = time();
		$key = ($arrRow['published'] && ($arrRow['start'] == '' || $arrRow['start'] < $time) && ($arrRow['stop'] == '' || $arrRow['stop'] > $time)) ? 'published' : 'unpublished';
		$date = $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['date']);
		
		return '
<div class="cte_type ' . $key . '"><strong>' . $arrRow['title'] . '</strong> - ' . $date . '</div>';
	
	}


	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_pk_careerCenter_items::published', 'alexf'))
		{
			return '';
		}

		$href .= '&tid='.$row['id'].'&state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}		

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}


	/**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');
		$this->checkPermission();

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_pk_careerCenter_items::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish career-center item ID "'.$intId.'"', 'tl_pk_careerCenter_items toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_pk_careerCenter_items', $intId);
	
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_pk_careerCenter_items']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_pk_careerCenter_items']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_pk_careerCenter_items SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_pk_careerCenter_items', $intId);
	}	
	
	
	/**
	 * Adjust start end end time of the event based on date, span, startTime and endTime
	 * @param object
	 */
	public function adjustTime(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

		$arrSet['date'] = strtotime(date('Y-m-d', $dc->activeRecord->date) . ' ' . date('H:i:s', $dc->activeRecord->time));
		$arrSet['time'] = $arrSet['date'];

		$this->Database->prepare("UPDATE tl_pk_careerCenter_items %s WHERE id=?")->set($arrSet)->execute($dc->id);
	}
}

?>