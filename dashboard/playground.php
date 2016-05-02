<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Playground.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'draw':
		playgroundDraw();
		break;
	case 'delete':
		playgroundDelete();
		break;
	case 'playgroundBorder':
		playgroundBorder();
		break;
	case 'drawGreenArea':
		drawGreenArea();
		break;
	default:
		playgroundList();
}

function drawGreenArea() {
	User::allowExecute(3);
	$region = Region::getRegion($_SESSION['login']['region_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	$sections = Playground::getRegionPlaygrounds($_SESSION['login']['region_id']);
	if (isset($_POST['saveSection'])) {
		$section = Playground::savePlayground($_POST);
		if($section == FALSE) {
			header( "Location: playground.php?status=unSuccess" );
		} else {
			header( "Location: playground.php?status=sectionSaved" );
		}
	}
	require(ADMIN_TEMPLATE . "playgrounds/drawGreenArea.php");
}

function playgroundDelete() {
	User::allowExecute(3);
	$section = Playground::deletePlayground($_GET['id']);
	if($section == 0) {
		header( "Location: playground.php?status=deleteUnsuccess" );
	} else {
		header( "Location: playground.php?status=deleteSuccess" );	
	}
}

function playgroundDraw() {
	User::allowExecute(3);
	$region = Region::getRegion($_SESSION['login']['region_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	$sections = Playground::getRegionPlaygrounds2015($_SESSION['login']['region_id']);
	if (isset($_POST['saveSection'])) {
		$section = Playground::savePlayground($_POST);
		if($section == FALSE) {
			header( "Location: playground.php?status=unSuccess" );
		} else {
			header( "Location: playground.php?status=sectionSaved" );
		}
	}
	require(ADMIN_TEMPLATE . "playgrounds/playgroundDraw.php");
}

function playgroundBorder() {
	User::allowExecute(3);
	$results = Playground::getPlaygroundBorder($_GET['section']);
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

function playgroundList() {
	User::allowExecute(array(3));
	$results = array();
	$data = Playground::getRegionList2015($_SESSION['login']['region_id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "sectionSaved" ) $results['statusMessage'] = "Ногоон байгууламж амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unSuccess" ) $results['statusMessage'] = "Алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['deleteUnsuccess'] = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['deleteSuccess'] = "Амжилттай устгагдлаа.";
  	}
  	$districtHeader = District::getDistrict($_SESSION['login']['district_id']);
	$regionHeader = Region::getRegion($_SESSION['login']['region_id']);
	require( ADMIN_TEMPLATE . "playgrounds/playgroundList.php" );
}

?>