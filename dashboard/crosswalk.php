<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Crosswalk.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Year.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'draw':
		crosswalkDraw();
		break;
	case 'delete':
		crosswalkDelete();
		break;
	case 'crosswalkBorder':
		crosswalkBorder();
		break;
	case 'crosswalkCalculate':
		crosswalkCalculate();
		break;
	case 'calculateArea':
		calculateArea();
		break;
	default:
		crosswalkList();
}

function calculateArea() {
	$section = Crosswalk::calculateArea($_POST);
}

function crosswalkCalculate() {
	User::allowExecute(array(1,3));
	//$sections = Section::getRegionSections($_GET['region']);
	$districts = District::getDistrictList();
	require(ADMIN_TEMPLATE . "crosswalk/crosswalkCalculate.php");
}

function crosswalkDelete() {
	User::allowExecute(3);
	$section = Crosswalk::deleteCrosswalks($_GET['id']);
	if($section == 0) {
		header( "Location: crosswalk.php?status=deleteUnsuccess" );
	} else {
		header( "Location: crosswalk.php?status=deleteSuccess" );	
	}
}

function crosswalkDraw() {
	User::allowExecute(3);
	$years = Year::getYearList();
	$region = Region::getRegion($_SESSION['login']['region_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	$sections = Crosswalk::getRegionCrosswalks($_SESSION['login']['region_id']);
	if (isset($_POST['saveSection'])) {
		$section = Crosswalk::saveCrosswalks($_POST);
		if($section == FALSE) {
			header( "Location: crosswalk.php?status=unSuccess" );
		} else {
			header( "Location: crosswalk.php?status=sectionSaved" );
		}
	}
	require(ADMIN_TEMPLATE . "crosswalk/crosswalkDraw.php");
}

function crosswalkBorder() {
	User::allowExecute(3);
	$results = Crosswalk::getCrosswalksBorder($_GET['section']);
	preg_match_all("/\(([^\)]*)\)/", $results['coordinate'], $matches);
	$data['coordinate'] = array();
	$k = 0;
	foreach($matches[1] as $result) {
		$data['coordinate'][$k] = explode(',', $result, 2);
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function crosswalkList() {
	User::allowExecute(array(3));
	$results = array();
	$data = Crosswalk::getRegionList($_SESSION['login']['region_id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "sectionSaved" ) $results['statusMessage'] = "Үерийн аюултай бүс амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unSuccess" ) $results['statusMessage'] = "Алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['deleteUnsuccess'] = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['deleteSuccess'] = "Амжилттай устгагдлаа.";
  	}
  	$districtHeader = District::getDistrict($_SESSION['login']['district_id']);
	$regionHeader = Region::getRegion($_SESSION['login']['region_id']);
	require( ADMIN_TEMPLATE . "crosswalk/crosswalkList.php" );
}

?>