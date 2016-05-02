<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Earthground.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'draw':
		earthgroundDraw();
		break;
	case 'delete':
		earthgroundDelete();
		break;
	case 'earthgroundBorder':
		earthgroundBorder();
		break;
	default:
		earthgroundList();
}

function earthgroundDelete() {
	User::allowExecute(3);
	$section = Earthground::deleteEarthground($_GET['id']);
	if($section == 0) {
		header( "Location: earthground.php?status=deleteUnsuccess" );
	} else {
		header( "Location: earthground.php?status=deleteSuccess" );	
	}
}

function earthgroundDraw() {
	User::allowExecute(3);
	$region = Region::getRegion($_SESSION['login']['region_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	$sections = Earthground::getRegionEarthgrounds2015($_SESSION['login']['region_id']);
	if (isset($_POST['saveSection'])) {
		$section = Earthground::saveEarthground($_POST);
		if($section == FALSE) {
			header( "Location: earthground.php?status=unSuccess" );
		} else {
			header( "Location: earthground.php?status=sectionSaved" );
		}
	}
	require(ADMIN_TEMPLATE . "earthground/earthgroundDraw.php");
}

function earthgroundBorder() {
	User::allowExecute(3);
	$results = Earthground::getEarthgroundBorder($_GET['section']);
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

function earthgroundList() {
	User::allowExecute(array(3));
	$results = array();
	$data = Earthground::getRegionList2015($_SESSION['login']['region_id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "sectionSaved" ) $results['statusMessage'] = "Сул шороон хөрстэй талбай амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unSuccess" ) $results['statusMessage'] = "Алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['deleteUnsuccess'] = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['deleteSuccess'] = "Амжилттай устгагдлаа.";
  	}
  	$districtHeader = District::getDistrict($_SESSION['login']['district_id']);
	$regionHeader = Region::getRegion($_SESSION['login']['region_id']);
	require( ADMIN_TEMPLATE . "earthground/earthgroundList.php" );
}

?>