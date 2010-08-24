<?php

$ga = new GoogleAnalytics();
$ga->injectJavascript();
if (is_array($GLOBALS['TL_MOOTOOLS']))
	echo implode("\n", $GLOBALS['TL_MOOTOOLS']);

?>