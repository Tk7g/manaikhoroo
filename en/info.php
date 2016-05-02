<?php
error_reporting(0);
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'getDistrictInfo' :
		getDistrictInfo();
		break;
	case 'logout':
		logout();
		break;
	default:
		header("Location: index.php");
}

function getDistrictInfo() {
	$results = Info::DistrictInfo($_GET['district']);
	require(SITE_TEMPLATE . "infos/infoDistrict.php");
}

?>