<?php
//error_reporting(0);
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Report.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Link.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Playground.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Torongarts.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Risks.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Road.class.php");
require_once(realpath(dirname(__FILE__))."/classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Year.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Jenks.class.php");

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'regionCrimeAnalysis':
		regionCrimeAnalysis();
		break;
}

function regionCrimeAnalysis() {
	$district = District::getDistrict($_GET['district']);
	$regions = Region::getRegionList($district['id']);
	
	require(SITE_TEMPLATE . "analysis/regionCrimeAnalysis.php");
}

?>