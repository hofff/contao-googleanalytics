<?php

/**
 * PHP version 5
 *
 * @copyright  Jan Theofel 2011, ETES GmbH 2010
 * @author     Jan Theofel <jan@theofelde>
 * @author     Christopher Bölter <christopher@hofff.com>
 * @author     Cliff Parnitzky <contao@cliff-parnitzky.de>
 * @package    googleanalytics
 * @license    LGPL
 * @filesource
 */

$arrRootPages = array("root", "rootfallback");
foreach($arrRootPages as $pageType)
{

  $GLOBALS['TL_DCA']['tl_page']['palettes'][$pageType] = str_replace(
      '{publish_legend}',
      '{googleanalytics_legend},ga_analyticsid,ga_setdomainname,ga_ignoreadmins,ga_ignoremembers,ga_anonymizeip,ga_eventtracking,ga_bounceseconds,ga_externaltracking,ga_addlinktracking;{publish_legend}',
      $GLOBALS['TL_DCA']['tl_page']['palettes'][$pageType]
  );
}

$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][]        = 'ga_addlinktracking';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['ga_addlinktracking'] = 'ga_titlelinktracking';

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_analyticsid'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_analyticsid'],
    'inputType' => 'text',
    'eval'      => array('size' => 20, 'tl_class' => 'w50'),
    'sql'       => "varchar(20) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_anonymizeip'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_anonymizeip'],
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50'),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_eventtracking'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_eventtracking'],
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50'),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_ignoreadmins'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_ignoreadmins'],
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50'),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_ignoremembers'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_ignoremembers'],
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50'),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_externaltracking'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_externaltracking'],
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50'),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_addlinktracking'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_addlinktracking'],
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50', 'submitOnChange' => true),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_setdomainname'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_setdomainname'],
    'inputType' => 'text',
    'eval'      => array('size' => 150, 'tl_class' => 'w50'),
    'sql'       => "char(150) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_titlelinktracking'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_titlelinktracking'],
    'inputType' => 'text',
    'eval'      => array('size' => 150, 'tl_class' => 'w50'),
    'sql'       => "char(150) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_page']['fields']['ga_bounceseconds'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['ga_bounceseconds'],
    'inputType' => 'text',
    'eval'      => array('size' => 10, 'tl_class' => 'w50', 'rgxp' => 'digit'),
    'sql'       => "int(10) unsigned NOT NULL default '0'",
);
