<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Road.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'draw':
		roadDraw();
		break;
	case 'add':
		roadAdd();
		break;
	case 'delete':
		roadDelete();
		break;
	case 'roadBorder':
		roadBorder();
		break;
	default:
		roadList();
}

function roadDelete() {
	User::allowExecute(3);
	$road = Road::deleteRoad($_GET['id']);
	if($road == 0) {
		header( "Location: road.php?status=deleteUnsuccess" );
	} else {
		header( "Location: road.php?status=deleteSuccess" );	
	}
}

function roadDraw() {
	User::allowExecute(3);
	$region = Region::getRegion($_SESSION['login']['region_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	$roads = Road::getRegionRoads($_SESSION['login']['region_id']);
	if (isset($_POST['saveRoad'])) {
		$road = Road::saveRoad($_POST);
		if($road == FALSE) {
			header( "Location: road.php?status=unSuccess" );
		} else {
			header( "Location: road.php?status=roadSaved" );
		}
	}
	require(ADMIN_TEMPLATE . "roads/roadDraw.php");
}

function roadBorder() {
	User::allowExecute(3);
	$results = Road::getRoadBorder($_GET['road']);
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

function roadAdd() {
	User::allowExecute(3);
	$districts = District::getDistrictList();
	if (isset($_POST['selectRegion'])) {
		header( "Location: road.php?action=draw&district=".$_POST['district_id']."&region=".$_POST['region_id'] );	
	}
	require(ADMIN_TEMPLATE . "roads/roadAdd.php");
}

function roadList() {
	User::allowExecute(array(3));
	$results = array();
	$data = Road::getList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "roadSaved" ) $results['statusMessage'] = "Замын зураглал амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unSuccess" ) $results['statusMessage'] = "Алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['deleteUnsuccess'] = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['deleteSuccess'] = "Амжилттай устгагдлаа.";
  	}
	require( ADMIN_TEMPLATE . "roads/roadList.php" );
}

?>