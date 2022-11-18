<?php

/**
 * @copyright  Jan Theofel 2011, ETES GmbH 2010
 * @author     Jan Theofel <jan@theofelde>
 * @author     Christopher Bölter <christopher@hofff.com>
 * @package    googleanalytics
 * @license    LGPL
 * @filesource
 */

namespace Hofff\GoogleAnalyticsBundle\Frontend;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\PageModel;
use Hofff\Contao\Consent\Bridge\ConsentId\ConsentIdParser;
use Hofff\Contao\Consent\Bridge\ConsentToolManager;
use Hofff\Contao\Consent\Bridge\Exception\InvalidArgumentException;

class GoogleAnalytics
{
    /**
     * Consent tool manager.
     *
     * @var ConsentToolManager
     */
    private $consentToolManager;

    /**
     * Consent Id parser.
     *
     * @var ConsentIdParser
     */
    private $consentIdParser;

    public function __construct(ConsentToolManager $consentToolManager, ConsentIdParser $consentIdParser)
    {
        $this->consentToolManager = $consentToolManager;
        $this->consentIdParser    = $consentIdParser;
    }

    /** @Hook("parseFrontendTemplate") */
    public function addGoogleAnalytics(string $strContent): string
    {
        // GA already included
        if ($GLOBALS['googleanalytics_included']) {
            return $strContent;
        }

        $GLOBALS['googleanalytics_included'] = 'true';
        global $objPage;
        $root_details = PageModel::findByPk($objPage->rootId);

        if ($root_details && $root_details->ga_analyticsid != '') {
            // Ignore admins and/or members
            if (($root_details->ga_ignoreadmins && Input::cookie('BE_USER_AUTH'))
                || ($root_details->ga_ignoremembers && FE_USER_LOGGED_IN)
            ) {
                return $strContent;
            }

            // parse template file
            $objTemplate                      = new FrontendTemplate('googleanalytics_consent');
            $objTemplate->id                  = $root_details->ga_analyticsid;
            $objTemplate->addTrackEvent       = ($root_details->ga_externaltracking || $root_details->ga_eventtracking
                                                 || $root_details->ga_addlinktracking);
            $objTemplate->addExternalTracking = $root_details->ga_externaltracking;
            $objTemplate->anonymizeIp         =
                ($root_details->ga_anonymizeip || $GLOBALS['TL_CONFIG']['privacyAnonymizeGA']);
            $objTemplate->setDomainName       = $root_details->ga_setdomainname ?: 'auto';
            $objTemplate->bounceseconds       = $root_details->ga_bounceseconds;
            $objTemplate->addlinktracking     = $root_details->ga_addlinktracking;
            $objTemplate->titlelinktracking   = $root_details->ga_titlelinktracking;

            $GLOBALS['TL_HEAD'][] = $this->applyConsentTool($objTemplate->parse(), $root_details->ga_consentId);

            $objTemplate->setName('mod_googleanalytics');
            $GLOBALS['TL_HEAD'][] = $objTemplate->parse();
        }

        return $strContent;
    }

    /**
     * function to add Googles TOS text with an insert tag
     * using switch to add other functions later
     *
     * @Hook("replaceInsertTags")
     */
    public function gaInsertTag(string $strTag)
    {
        $arrTag = explode('::', $strTag);

        if ($arrTag[0] !== 'ga') {
            return false;
        }

        switch ($arrTag[1]) {
            // Insert article count
            case 'privacytext':
                return $GLOBALS['TL_LANG']['MSC']['gaprivacytext'];
        }

        return false;
    }

    private function applyConsentTool(string $buffer, ?string $rawConsentId): string
    {
        if (null === $rawConsentId) {
            return $buffer;
        }

        $consentTool = $this->consentToolManager->activeConsentTool();
        if (null === $consentTool) {
            return $buffer;
        }

        try {
            $consentId = $this->consentIdParser->parse($rawConsentId);
            $buffer    = $consentTool->renderRaw($buffer, $consentId);
        } catch (InvalidArgumentException $exception) {}

        return $buffer;
    }
}
