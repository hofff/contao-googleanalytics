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


class GoogleAnalytics extends Frontend
{

	public function __construct()
	{
		return parent::__construct();
	}

	public function showRegularPageFields($dc)
	{
		if ($this->Input->get('act') != 'edit')
			return;

		$objPage = $this->getPageDetails($dc->id);
		$objRootPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")->limit(1)->execute($objPage->rootId);

		if ($objRootPage->ga_enabled)
		{
			$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] .= ';{ga_legend},ga_events,ga_customvars,ga_tracktransition';
		}
	}


	public function injectJavascript()
	{
		global $objPage;

		$objRootPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")->limit(1)->execute($objPage->rootId);

		if (!$objRootPage->numRows || !$objRootPage->ga_enabled)
			return;

		$strBuffer = '
new Element("script", {
    type: "text/javascript",
    href: ((("https:" == document.location.protocol) ? "https://ssl." : "http://www.") + "google-analytics.com/ga.js")
}).inject(document.head);
try {
';

		$arrTrackers = array();
		$arrTrackingCodes = deserialize($objRootPage->ga_trackingcodes);
		if (is_array($arrTrackingCodes) && count($arrTrackingCodes))
		{
			$arrBuffer = array();

			foreach( $arrTrackingCodes as $row )
			{
				list($name, $code) = $row;

				if (!strlen($name) || !strlen($code))
					continue;

				$arrTrackers[] = $name;
				$arrBuffer[] = sprintf("var %s = _gat._getTracker('%s');", $name, $code);
			}

			if (count($arrBuffer))
			{
				$strBuffer .= implode("\n", $arrBuffer);
			}
		}

		$strBuffer .= "\n" . $objRootPage->ga_code . "\n";

		if (count($arrTrackers))
		{
			$arrBuffer = array();

			foreach( $arrTrackers as $tracker )
			{
				$arrBuffer[] = sprintf("%s._trackPageview();\n", $tracker);
			}

			$strBuffer .= implode("\n", $arrBuffer);

			$arrEvents = deserialize($objPage->ga_events);

			if (is_array($_SESSION['GoogleAnalytics']['trackEvent']) && count($_SESSION['GoogleAnalytics']['trackEvent']))
			{
				$arrEvents = is_array($arrEvents) ? array_merge($arrEvents, $_SESSION['GoogleAnalytics']['trackEvent']) : $_SESSION['GoogleAnalytics']['trackEvent'];
				unset($_SESSION['GoogleAnalytics']['trackEvent']);
			}

			if (is_array($arrEvents) && count($arrEvents))
			{
				$arrBuffer = array();

				foreach( $arrEvents as $row )
				{
					list($category, $action, $label, $value) = $row;

					if (!strlen($category) || !strlen($action))
						continue;

					foreach( $arrTrackers as $tracker )
					{
						$arrBuffer[] = sprintf("%s._trackEvent('%s', '%s', '%s', '%s');", $tracker, $category, $action, $label, $value);
					}
				}

				if (count($arrBuffer))
				{
					$strBuffer .= implode("\n", $arrBuffer);
				}
			}

			$arrCustomVars = deserialize($objPage->ga_customvars);
			if (is_array($arrCustomVars) && count($arrCustomVars))
			{
				$arrBuffer = array();

				foreach( $arrCustomVars as $i => $row )
				{
					list($name, $value, $scope) = $row;

					if (!strlen($name) || !strlen($value) || !strlen($scope))
						continue;

					foreach( $arrTrackers as $tracker )
					{
						$arrBuffer[] = sprintf("%s._setCustomVar('%s', '%s', '%s', '%s');", $tracker, $i, $name, $value, $scope);
					}
				}

				if (count($arrBuffer))
				{
					$strBuffer .= implode("\n", $arrBuffer);
				}
			}

			if ($objPage->ga_tracktransition)
			{
				$arrItems = deserialize($objPage->ga_ecitems);
				if (is_array($arrItems) && count($arrItems))
				{
					$arrBuffer = array();

					foreach( $arrItems as $row )
					{
						list($id, $sku, $name, $category, $price, $quality) = $row;

						if (!strlen($id) || !strlen($sku) || !strlen($name) || !strlen($category) || !strlen($price) || !strlen($quantity))
							continue;

						foreach( $arrTrackers as $tracker )
						{
							$arrBuffer[] = sprintf("%s._addItem('%s', '%s', '%s', '%s', '%s', '%s');", $tracker, $id, $sku, $name, $category, $price, $quantity);
						}
					}

					if (count($arrBuffer))
					{
						$strBuffer .= implode("\n", $arrBuffer);
					}
				}

				$arrTransitions = deserialize($objPage->ga_ectrans);
				if (is_array($arrTransitions) && count($arrTransitions))
				{
					$arrBuffer = array();

					foreach( $arrTransitions as $row )
					{
						list($id, $affiliation, $total, $tax, $shipping, $city, $state, $country) = $row;

						if (!strlen($id) || !strlen($affiliation) || !strlen($total) || !strlen($tax) || !strlen($shipping) || !strlen($city) || !strlen($state) || !strlen($country))
							continue;

						foreach( $arrTrackers as $tracker )
						{
							$arrBuffer[] = sprintf("%s._addTrans('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');", $tracker, $id, $affiliation, $total, $tax, $shipping, $city, $state, $country);
						}
					}

					if (count($arrBuffer))
					{
						$strBuffer .= implode("\n", $arrBuffer);
					}
				}
			}
		}

		if (isset($GLOBALS['TL_HOOKS']['googleTracking']) && is_array($GLOBALS['TL_HOOKS']['googleTracking']))
		{
			foreach ($GLOBALS['TL_HOOKS']['googleTracking'] as $callback)
			{
				$this->import($callback[0]);
				$strBuffer .= $this->$callback[0]->$callback[1]();
			}
		}

		$strBuffer .= "} catch(err) {}\n";

		if (in_array('cookielaw', $this->Config->getActiveModules()))
		{
    		$strBuffer = '
window.cookielaw.onPermission(function() {' . $strBuffer . '});
';
		}

		$GLOBALS['TL_MOOTOOLS'][] = '<script type="text/javascript">' . $strBuffer . '</script>';
	}


	public function trackDownload($strFile)
	{
		if (is_file(TL_ROOT . '/' . $strFile))
		{
			$objFile = new File($strFile);

			$_SESSION['GoogleAnalytics']['trackEvent'][] = array('Downloads', strtoupper($objFile->extension), $strFile);
		}
	}
}

