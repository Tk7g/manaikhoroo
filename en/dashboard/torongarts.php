<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Torongarts.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'draw':
		torongartsDraw();
		break;
	case 'delete':
		torongartsDelete();
		break;
	case 'torongartsBorder':
		torongartsBorder();
		break;
	default:
		torongartsList();
}

function torongartsDelete() {
	User::allowExecute(3);
	$section = Torongarts::deleteTorongarts($_GET['id']);
	if($section == 0) {
		header( "Location: torongarts.php?status=deleteUnsuccess" );
	} else {
		header( "Location: torongarts.php?status=deleteSuccess" );	
	}
}

function torongartsDraw() {
	User::allowExecute(3);
	$region = Region::getRegion($_SESSION['login']['region_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	$sections = Torongarts::getRegionTorongarts($_SESSION['login']['region_id']);
	if (isset($_POST['saveSection'])) {
		$section = Torongarts::saveTorongarts($_POST);
		if($section == FALSE) {
			header( "Location: torongarts.php?status=unSuccess" );
		} else {
			header( "Location: torongarts.php?status=sectionSaved" );
		}
	}
	require(ADMIN_TEMPLATE . "torongarts/torongartsDraw.php");
}

function torongartsBorder() {
	User::allowExecute(3);
	$results = Torongarts::getTorongartsBorder($_GET['section']);
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

function torongartsList() {
	User::allowExecute(array(3));
	$results = array();
	$data = Torongarts::getList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "sectionSaved" ) $results['statusMessage'] = "Торон гарц амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unSuccess" ) $results['statusMessage'] = "Алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['deleteUnsuccess'] = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['deleteSuccess'] = "Амжилттай устгагдлаа.";
  	}
	require( ADMIN_TEMPLATE . "torongarts/torongartsList.php" );
}

?>