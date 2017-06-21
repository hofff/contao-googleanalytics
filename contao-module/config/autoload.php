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

/**
 * Register the templates
 */
TemplateLoader::addFiles(
    array
    (
        'ce_download_ga'      => 'system/modules/googleanalytics/templates',
        'ce_downloads_ga'     => 'system/modules/googleanalytics/templates',
        'mod_googleanalytics' => 'system/modules/googleanalytics/templates',
    )
);
