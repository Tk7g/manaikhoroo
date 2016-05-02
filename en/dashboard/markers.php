<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require(realpath(dirname(__FILE__))."/../classes/Marker.class.php");
require(realpath(dirname(__FILE__))."/../classes/Year.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'getMarkers':
		getMarkers();
		break;
	case 'markerRegion':
		markerRegion();
		break;
	case 'saveDistrict':
		saveDistrict();
		break;
	case 'delMarker':
		delMarker();
		break;
	case 'regionAdd':
		regionAdd();
		break;
	case 'regionDel':
		regionDel();
		break;
	case 'getRegionMarkers':
		getRegionMarkers();
		break;
	case 'select':
		typeSelect();
		break;
	case 'delselect':
		delTypeSelect();
		break;
	case 'regionBorder':
		regionBorder();
		break;
	case 'districtAdd':
		districtAdd();
		break;
	case 'districtDel':
		districtDel();
		break;
	case 'civDistrictMarker':
		civDistrictMarker();
		break;
	case 'civRegionMarker':
		civRegionMarker();
		break;
	case 'civRegionMarkerAccept':
		civRegionMarkerAccept();
		break;
	case 'civDistrictMarkerAccept':
		civDistrictMarkerAccept();
		break;
	case 'civRegionMarkerDecline':
		civRegionMarkerFull();
		break;
	case 'civRegionMarkers':
		civRegionMarkers();
		break;
	case 'civRegionMarkerAccepted':
		civRegionMarkerAccepted();
		break;
	case 'civDistrictMarkerDecline':
		civDistrictMarkerDecline();
		break;
	case 'civDistrictMarkerAccepted':
		civDistrictMarkerAccepted();
		break;
	default:
		districtMarkers();
}

function civDistrictMarkerAccept() {
	User::allowExecute(2);
	$marker = Marker::getCivDistrictMarker($_GET['marker'], 0);
	if (isset($_POST['acceptMarker'])) {
			if($_SESSION['login']['group_id'] == 2) {
				Marker::acceptDistrict($_POST);
				header( "Location: markers.php?action=civDistrictMarker&district=".$_SESSION['login']['district_id'] );
			} else {
				header( "Location: index.php" );	
			}
		}
	require(ADMIN_TEMPLATE . "markers/civDistrictMarkerAccept.php");
}

function civDistrictMarkerAccepted() {
	User::allowExecute(2);
	$markers = Marker::getCivDistrictMarkers($_GET['district'], 1);
	require(ADMIN_TEMPLATE . "markers/civDistrictMarker.php");
}

function civDistrictMarker() {
	User::allowExecute(2);
	$markers = Marker::getCivDistrictMarkers($_GET['district'], 0);
	require(ADMIN_TEMPLATE . "markers/civDistrictMarker.php");
}

function civRegionMarkerAccept() {
	User::allowExecute(3);
	$marker = Marker::getCivMarker($_GET['marker'], 0);
	if (isset($_POST['acceptMarker'])) {
			if($_SESSION['login']['group_id'] == 3) {
				Marker::acceptRegion($_POST);
				header( "Location: markers.php?action=civRegionMarker&region=".$_SESSION['login']['region_id'] );
			} else {
				header( "Location: index.php" );	
			}
		}
	require(ADMIN_TEMPLATE . "markers/civRegionMarkerAccept.php");
}

function civDistrictMarkerDecline() {
	User::allowExecute(2);
	$marker = Marker::getCivDistrictMarker($_GET['marker'], 1);
	if (isset($_POST['declineMarker'])) {
			if($_SESSION['login']['group_id'] == 2) {
				Marker::declineDistrict($_POST);
				header( "Location: markers.php?action=civDistrictMarkerAccepted&district=".$_SESSION['login']['district_id'] );
			} else {
				header( "Location: index.php" );	
			}
		}
	require(ADMIN_TEMPLATE . "markers/civDistrictMarkerDecline.php");
}

function civRegionMarkerFull() {
	User::allowExecute(3);
	$marker = Marker::getCivMarker($_GET['marker'], 1);
	if (isset($_POST['declineMarker'])) {
		if($_SESSION['login']['group_id'] == 3) {
			Marker::declineRegion($_POST);
			header( "Location: markers.php?action=civRegionMarkerAccepted&region=".$_SESSION['login']['region_id'] );
		} else {
			header( "Location: index.php" );	
		}
	}
	require(ADMIN_TEMPLATE . "markers/civRegionMarkerFull.php");
}

function civRegionMarkerAccepted() {
	User::allowExecute(3);
	$markers = Marker::getCivMarkers($_GET['region'], 1);
	require(ADMIN_TEMPLATE . "markers/civRegionMarker.php");
}

function civRegionMarker() {
	User::allowExecute(3);
	$markers = Marker::getCivMarkers($_GET['region'], 0);
	require(ADMIN_TEMPLATE . "markers/civRegionMarker.php");
}

function markerRegion() {
	User::allowExecute(3);
	$results = MARKER::countRegionMarkers($_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
	require( ADMIN_TEMPLATE . "markers/regionMarkers.php" );
}

function delMarker() {
	User::allowExecute(array(2,3));
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$marker = Marker::deleteMarker($_GET['type'], $_POST);
		if($marker == 0) {
			echo "Устгах явцад алдаа гарлаа.";
		} else {
			echo "Тэмдэглэгээ амжилттай устгагдлаа";	
		}
	}
}

function saveDistrict() {
	User::allowExecute(array(2,3));
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$marker = Marker::saveMarker($_GET['type'], $_POST, $_SESSION['login']['username']);
		if($marker == FALSE) {
			echo "Хадгалах явцад алдаа гарлаа.";
		} else {
			echo "Тэмдэглэгээ амжилттай хадгалагдлаа";	
		}
	}
}

function civRegionMarkers() {
	User::allowExecute(array(2,3));
	if($_SESSION['login']['group_id'] == 3) {
		$results = Marker::civRegionMarkers($_GET['type'], $_SESSION['login']['region_id'], $_GET['region_accept']);	
	} elseif($_SESSION['login']['group_id'] == 2) {
		$results = Marker::civRegionMarkers($_GET['type'], $_GET['region'], $_GET['region_accept']);
	}
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function getRegionMarkers() {
	User::allowExecute(3);
	$results = Marker::regionMarkers($_GET['type'], $_SESSION['login']['region_id']);
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function getMarkers() {
	User::allowExecute(2);
	$results = Marker::districtMarkers($_GET['type'], $_SESSION['login']['district_id']);
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function regionBorder() {
		User::allowExecute(array(1,2,3));
		$results = Marker::getRegionborder($_GET['region']);
		$data['coordinate'] = array();
		$k = 0;
		foreach($results as $result) {
			$data['coordinate'][$k] = explode(',', $result['coordinate'], 2);
			$k = $k + 1;
		}
		header('Content-type: application/json');
		echo json_encode($data);
}

function districtMarkers() {
	User::allowExecute(2);
	$results = MARKER::countMarkers($_SESSION['login']['district_id']);
	require( ADMIN_TEMPLATE . "markers/districtMarkers.php" );
}

function typeSelect() {
		User::allowExecute(array(2,3));
		$results = Marker::selectType($_SESSION['login']['district_id']);
		if (isset($_POST['selectType'])) {
			if($_SESSION['login']['group_id'] == 3) {
				header( "Location: markers.php?action=regionAdd&type=".$_POST['type_id'] );
			} else {
				header( "Location: markers.php?action=districtAdd&type=".$_POST['type_id'] );	
			}
		}
		require(ADMIN_TEMPLATE . "markers/markerType.php");
}

function districtDel() {
	User::allowExecute(2);
	$results = Marker::addDistrictMarker($_GET['type'], $_SESSION['login']['district_id']);
	require(ADMIN_TEMPLATE . "markers/districtDel.php");
}

function regionDel() {
	User::allowExecute(3);
	$results = Marker::addRegionMarker($_GET['type'], $_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
	require(ADMIN_TEMPLATE . "markers/regionDel.php");
}

function delTypeSelect() {
		User::allowExecute(array(2,3));
		$results = Marker::selectType($_SESSION['login']['district_id']);
		if (isset($_POST['selectType'])) {
			if($_SESSION['login']['group_id'] == 3) {
				header( "Location: markers.php?action=regionDel&type=".$_POST['type_id'] );
			} else {
				header( "Location: markers.php?action=districtDel&type=".$_POST['type_id'] );	
			}
		}
		require(ADMIN_TEMPLATE . "markers/markerType.php");
}

function regionAdd() {
	User::allowExecute(3);
	$results = Marker::addRegionMarker($_GET['type'], $_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
	$years = Year::getYearList();
	require(ADMIN_TEMPLATE . "markers/regionAdd.php");
}

function districtAdd() {
	User::allowExecute(2);
	$results = Marker::addDistrictMarker($_GET['type'], $_SESSION['login']['district_id']);
	require(ADMIN_TEMPLATE . "markers/districtAdd.php");
}

?>