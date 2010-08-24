<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005-2009 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id$
 */
 

/**
 * Config
 */
$GLOBALS['TL_DCA']['tl_page']['config']['onload_callback'][] = array('GoogleAnalytics', 'showRegularPageFields');


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'ga_enabled';
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'ga_tracktransition';
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] .= ';{ga_legend},ga_enabled';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['ga_enabled'] = 'ga_script,ga_trackingcodes,ga_code';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['ga_tracktransition'] = 'ga_ecitems,ga_ectrans';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['ga_enabled'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_enabled'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array('submitOnChange'=>true),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_script'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_script'],
	'exclude'		=> true,
	'default'		=> '<script type="text/javascript">var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www."); document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));</script>',
	'inputType'		=> 'textarea',
	'eval'			=> array('style'=>'height: 60px', 'allowHtml'=>true, 'preserveTags'=>true),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_trackingcodes'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_trackingcodes'],
	'exclude'		=> true,
	'inputType'		=> 'multitextWizard',
	'eval'			=> array('columns'=>2),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_code'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_code'],
	'exclude'		=> true,
	'inputType'		=> 'textarea',
	'eval'			=> array('style'=>'height: 60px', 'preserveTags'=>true),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_events'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_events'],
	'exclude'		=> true,
	'inputType'		=> 'multitextWizard',
	'eval'			=> array('columns'=>4),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_customvars'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_customvars'],
	'exclude'		=> true,
	'inputType'		=> 'multitextWizard',
	'eval'			=> array('columns'=>3),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_tracktransition'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_tracktransition'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array('submitOnChange'=>true),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_ecitems'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_ecitems'],
	'exclude'		=> true,
	'inputType'		=> 'multitextWizard',
	'eval'			=> array('columns'=>6),
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_ectrans'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['ga_ectrans'],
	'exclude'		=> true,
	'inputType'		=> 'multitextWizard',
	'eval'			=> array('columns'=>7),
);

