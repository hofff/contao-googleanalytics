<?php

/**
 * PHP version 5
 *
 * @copyright  Jan Theofel 2011, ETES GmbH 2010
 * @author     Jan Theofel <jan@theofelde>
 * @author     Christopher Bölter <christopher@hofff.com>
 * @package    googleanalytics
 * @license    LGPL
 * @filesource
 */

// register parse template hook
$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] =
    array('Hofff\\Contao\\Frontend\\GoogleAnalytics', 'addGoogleAnalytics');

// register custom inserttags
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] =
    array('Hofff\\Contao\\Frontend\\GoogleAnalytics', 'gaInsertTag');
