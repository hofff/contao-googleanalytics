-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_page`
-- 

CREATE TABLE `tl_page` (
  `ga_enabled` char(1) NOT NULL default '',
  `ga_script` text NULL,
  `ga_trackingcodes` blob NULL,
  `ga_code` text NULL,
  `ga_events` blob NULL,
  `ga_customvars` blob NULL,
  `ga_tracktransition` char(1) NOT NULL default '',
  `ga_ecitems` blob NULL,
  `ga_ectrans` blob NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

