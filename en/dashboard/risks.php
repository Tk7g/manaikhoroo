<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Risks.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'draw':
		risksDraw();
		break;
	case 'delete':
		risksDelete();
		break;
	case 'risksBorder':
		risksBorder();
		break;
	default:
		risksList();
}

function risksDelete() {
	User::allowExecute(3);
	$section = Risks::deleteRisks($_GET['id']);
	if($section == 0) {
		header( "Location: risks.php?status=deleteUnsuccess" );
	} else {
		header( "Location: risks.php?status=deleteSuccess" );	
	}
}

function risksDraw() {
	User::allowExecute(3);
	$region = Region::getRegion($_SESSION['login']['region_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	$sections = Risks::getRegionRisks($_SESSION['login']['region_id']);
	if (isset($_POST['saveSection'])) {
		$section = Risks::saveRisks($_POST);
		if($section == FALSE) {
			header( "Location: risks.php?status=unSuccess" );
		} else {
			header( "Location: risks.php?status=sectionSaved" );
		}
	}
	require(ADMIN_TEMPLATE . "risks/risksDraw.php");
}

function risksBorder() {
	User::allowExecute(3);
	$results = Risks::getRisksBorder($_GET['section']);
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

function risksList() {
	User::allowExecute(array(3));
	$results = array();
	$data = Risks::getList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "sectionSaved" ) $results['statusMessage'] = "Үерийн аюултай бүс амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unSuccess" ) $results['statusMessage'] = "Алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['deleteUnsuccess'] = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['deleteSuccess'] = "Амжилттай устгагдлаа.";
  	}
	require( ADMIN_TEMPLATE . "risks/risksList.php" );
}

?>