<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require(realpath(dirname(__FILE__))."/../classes/Marker.class.php");
require(realpath(dirname(__FILE__))."/../classes/Type.class.php");
require(realpath(dirname(__FILE__))."/../classes/Region.class.php");
require(realpath(dirname(__FILE__))."/../classes/District.class.php");
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
	case 'regionAdd3':
		regionAdd3();
		break;
	case 'regionAdd2':
		regionAdd2();
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
	case 'districtAdd3':
		districtAdd3();
		break;
	case 'districtAddTest':
		districtAddTest();
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
	case 'civRegionMarkers1':
		civRegionMarkers1();
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
	case 'saveDesc':
		saveDesc();
		break;
	case 'getRegionPanelMarkers':
		getRegionPanelMarkers();
		break;
	case 'searchDistrictHistory':
		searchDistrictHistory();
		break;
	case 'districtMarkerHistory':
		districtMarkerHistory();
		break;
	case 'markerHistory':
		markerHistory();
		break;
	case 'searchHistory':
		searchHistory();
		break;
	case 'saveDescription':
		saveDescription();
		break;
	case 'saveDescription2':
		saveDescription2();
		break;
	case 'saveDescription3':
		saveDescription3();
		break;
	case 'saveAdminDescription':
		saveAdminDescription();
		break;
	case 'adminAdd':
		adminAdd();
		break;
	case 'adminAdd2':
		adminAdd2();
		break;
	case 'adminSelect':
		adminSelect();
		break;
	case 'adminDelSelect':
		adminDelSelect();
		break;
	case 'adminMarkers':
		adminMarkers();
		break;
	case 'adminDel':
		adminDel();
		break;
	case 'saveAdmin':
		saveAdmin();
		break;
	case 'getAdminMarkers':
		getAdminMarkers();
		break;
	default:
		districtMarkers();
}

function getDistrictName($district) {
	$name = District::getDistrict($district);
	return $name['title'];
}

function getRegionName($region) {
	$name = Region::getRegion($region);
	return $name['title'].'-р хороо';
}

function getMarkerTypeName($type) {
	$name = Type::getType($type);
	return $name['title'];
}

function searchHistory() {
	User::allowExecute(1);
	if (isset($_POST['searchButton'])) {
		header( "Location: markers.php?action=markerHistory&page=1&district=".$_POST['district']."&region=".$_POST['region']."&type=".$_POST['type'] );
	}
}

function searchDistrictHistory() {
	User::allowExecute(2);
	if (isset($_POST['searchButton'])) {
		header( "Location: markers.php?action=districtMarkerHistory&district=".$_POST['district']."&region=".$_POST['region']."&type=".$_POST['type'] );
	}
}

function districtMarkerHistory() {
	User::allowExecute(2);
	$page_title = 'Хороодын хэрэглэгчдийн зурган тэмдэглэгээ оруулсан түүх';
	$regions = Region::RegionList($_SESSION['login']['district_id']);
	$types = Type::getTypeList();
	if(isset($_GET['region']) && $_GET['region'] != NULL) {
		$getRegion = $_GET['region'];
	} else {
		$getRegion = NULL;
	}
	$data = Marker::getDistrictHistoryList($_GET['type'], $_SESSION['login']['district_id'], $getRegion);
	require(ADMIN_TEMPLATE . "markers/districtMarkerHistory.php");
}

function markerHistory() {
	User::allowExecute(1);
	 
	$page_title = 'Зурган мэдээлэллийн түүх';
	$districts = District::getDistrictList();
	if(isset($_GET['district'])) {
		if($_GET['district'] != NULL) {
			$regions = Region::getRegionList($_GET['district']);
		}
	}
	$types = Type::getTypeList();
  	if(isset($_GET['page'])) {
  		if(isset($_GET['district'])) {
			$getDistrict = $_GET['district'];
		} else {
			$getDistrict = NULL;
		}
		if(isset($_GET['region'])) {
			$getRegion = $_GET['region'];
		} else {
			$getRegion = NULL;
		}
		if(isset($_GET['type'])) {
			$getType = $_GET['type'];
		} else {
			$getType = NULL;
		}
		
		if($_GET['page'] == 1) {
			$data = Marker::getHistoryList(0, 100, $getDistrict, $getRegion, $getType);
		} elseif($_GET['page'] > 1) {
			$from = ($_GET['page'] - 1)*100;
			$data = Marker::getHistoryList($from, 100, $getDistrict, $getRegion, $getType);
		}
	}
	$total_pages = Marker::getTotalRows($getDistrict, $getRegion, $getType);
	$total_pagination = ceil($total_pages['COUNT(*)']/100);
	
	require(ADMIN_TEMPLATE . "markers/markerHistory.php");
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
	User::allowExecute(array(1,2,3));
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$marker = Marker::deleteMarker($_GET['type'], $_POST);
		if($marker == 0) {
			echo "Устгах явцад алдаа гарлаа.";
		} else {
			echo "Тэмдэглэгээ амжилттай устгагдлаа";	
		}
	}
}

function saveDescription() {
	User::allowExecute(array(2,3));
	if (isset($_POST['saveMarkerDesc'])) {
		$markerClass = new Marker;
		$marker = $markerClass->saveDescription($_GET['type'], $_POST, $_SESSION['login']['username'], $_FILES);
		if($marker == FALSE) {
			header( "Location: markers.php?action=regionAdd3&type=".$_GET['type']."&id=".$_POST['id']."&status=unsuccess" );
		} else {
			header( "Location: markers.php?action=regionAdd3&type=".$_GET['type']."&id=".$_POST['id']."&status=success" );	
		}
	}
}

function saveDescription2() {
	User::allowExecute(array(2,3));
	if (isset($_POST['saveMarkerDesc'])) {
		$markerClass = new Marker;
		$marker = $markerClass->saveDescription($_GET['type'], $_POST, $_SESSION['login']['username'], $_FILES);
		if($marker == FALSE) {
			header( "Location: markers.php?action=districtAdd&type=".$_GET['type']."&status=unsuccess" );
		} else {
			header( "Location: markers.php?action=districtAdd&type=".$_GET['type']."&status=success" );	
		}
	}
}

function saveDescription3() {
	User::allowExecute(array(2,3));
	if (isset($_POST['saveMarkerDesc'])) {
		$markerClass = new Marker;
		$marker = $markerClass->saveDescription($_GET['type'], $_POST, $_SESSION['login']['username'], $_FILES);
		if($marker == FALSE) {
			header( "Location: markers.php?action=districtAdd3&type=".$_GET['type']."&id=".$_POST['id']."&status=unsuccess" );
		} else {
			header( "Location: markers.php?action=districtAdd3&type=".$_GET['type']."&id=".$_POST['id']."&status=success" );	
		}
	}
}

function saveDesc() {
	User::allowExecute(array(2,3));
	if (isset($_POST['saveMarker'])) {
		$markerClass = new Marker;
		$marker = $markerClass->saveDesc($_GET['type'], $_POST, $_SESSION['login']['username'], $_FILES);
		if($marker == FALSE) {
			header( "Location: markers.php?action=regionAdd&type=".$_GET['type']."&status=unsuccess" );
		} else {
			header( "Location: markers.php?action=regionAdd&type=".$_GET['type']."&status=success" );	
		}
	}
}

function saveDistrict() {
	User::allowExecute(array(2,3));
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$marker = Marker::saveMarker($_GET['type'], $_POST, $_SESSION['login']['username']);
		if($marker == FALSE) {
			echo 0;
		} else {
			echo $marker;	
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

function civRegionMarkers1() {
	User::allowExecute(array(2,3));
	if($_SESSION['login']['group_id'] == 3) {
		$results = Marker::civRegionMarkers($_GET['type'], $_SESSION['login']['region_id'], $_GET['region_accept']);	
	} elseif($_SESSION['login']['group_id'] == 2) {
		$results = Marker::civRegionMarkers1($_GET['type'], $_GET['region'], $_GET['region_accept']);
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

function getRegionPanelMarkers() {
	User::allowExecute(3);
	$results = Marker::regionPanelMarkers($_GET['type'], $_SESSION['login']['region_id']);
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$data['info'][$k][] = $result['title'];
		$data['info'][$k][] = $result['phone'];
		$data['info'][$k][] = $result['email'];
		$data['info'][$k][] = $result['description'];
		$data['info'][$k][] = $result['image'];
		$data['id'][$k][] = $result['id'];
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
		$data['info'][$k][] = $result['title'];
		$data['info'][$k][] = $result['phone'];
		$data['info'][$k][] = $result['email'];
		$data['info'][$k][] = $result['description'];
		$data['info'][$k][] = $result['image'];
		$data['id'][$k][] = $result['id'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function getAdminMarkers() {
	User::allowExecute(1);
	$results = Marker::districtMarkers($_GET['type'], $_GET['district']);
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$data['info'][$k][] = $result['title'];
		$data['info'][$k][] = $result['phone'];
		$data['info'][$k][] = $result['email'];
		$data['info'][$k][] = $result['description'];
		$data['info'][$k][] = $result['image'];
		$data['id'][$k][] = $result['id'];
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
		if($_SESSION['login']['group_id'] == 3) {
			$regionHeader = Region::getRegion($_SESSION['login']['region_id']);	
		}
		require(ADMIN_TEMPLATE . "markers/markerType.php");
}

function districtDel() {
	User::allowExecute(2);
	$results = Marker::addDistrictMarker($_GET['type'], $_SESSION['login']['district_id']);
	$district_regions = Region::RegionList($_SESSION['login']['district_id']);
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

function regionAdd2() {
	User::allowExecute(3);
	$results = Marker::addRegionMarker($_GET['type'], $_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
	$years = Year::getYearList();
	$markers = Marker::regionPanelMarkers($_GET['type'], $_SESSION['login']['region_id']);
	require(ADMIN_TEMPLATE . "markers/regionAdd2.php");
}

function regionAdd() {
	User::allowExecute(3);
	$results = Marker::addRegionMarker($_GET['type'], $_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
	$years = Year::getYearList();
	require(ADMIN_TEMPLATE . "markers/regionAdd.php");
}

function regionAdd3() {
	User::allowExecute(3);
	$results = Marker::addRegionMarker($_GET['type'], $_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
	$current_marker = Marker::getMarker($_GET['id']);
	$years = Year::getYearList();
	require(ADMIN_TEMPLATE . "markers/regionAdd3.php");
}

function districtAddTest() {
	User::allowExecute(2);
	require(ADMIN_TEMPLATE . "markers/districtAddTest.php");
}

function districtAdd3() {
	User::allowExecute(2);
	require(ADMIN_TEMPLATE . "markers/districtAdd3.php");
}

function districtAdd() {
	User::allowExecute(2);
	require(ADMIN_TEMPLATE . "markers/districtAdd.php");
}

function adminAdd() {
	User::allowExecute(1);
	$current_district = District::getDistrict($_GET['district']);
	$regions = Region::RegionList($_GET['district']);
	$type = Type::getType($_GET['type']);
	require(ADMIN_TEMPLATE . "markers/adminAdd.php");
}

function adminAdd2() {
	User::allowExecute(1);
	$current_district = District::getDistrict($_GET['district']);
	$regions = Region::RegionList($_GET['district']);
	$type = Type::getType($_GET['type']);
	$current_marker = Marker::getMarker($_GET['id']);
	require(ADMIN_TEMPLATE . "markers/adminAdd2.php");
}

function adminDel() {
	User::allowExecute(1);
	$results = Marker::addDistrictMarker($_GET['type'], $_GET['district']);
	$district_regions = Region::RegionList($_GET['district']);
	require(ADMIN_TEMPLATE . "markers/adminDel.php");
}

function saveAdminDesc() {
	User::allowExecute(1);
	if (isset($_POST['saveMarker'])) {
		$markerClass = new Marker;
		$marker = $markerClass->saveDesc($_GET['type'], $_POST, $_SESSION['login']['username'], $_FILES);
		if($marker == FALSE) {
			header( "Location: markers.php?action=adminAdd2&type=".$_GET['type']."&district=".$_GET['district']."&status=unsuccess" );
		} else {
			header( "Location: markers.php?action=adminAdd2&type=".$_GET['type']."&district=".$_GET['district']."&status=success" );	
		}
	}
}

function saveAdminDescription() {
	User::allowExecute(1);
	if (isset($_POST['saveMarkerDesc'])) {
		$markerClass = new Marker;
		$marker = $markerClass->saveDescription($_GET['type'], $_POST, $_SESSION['login']['username'], $_FILES);
		if($marker == FALSE) {
			header( "Location: markers.php?action=adminAdd2&type=".$_GET['type']."&district=".$_GET['district']."&id=".$_POST['id']."&status=unsuccess" );
		} else {
			header( "Location: markers.php?action=adminAdd2&type=".$_GET['type']."&district=".$_GET['district']."&id=".$_POST['id']."&status=success" );	
		}
	}
}

function saveAdmin() {
	User::allowExecute(1);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$marker = Marker::saveMarker($_GET['type'], $_POST, $_SESSION['login']['username']);
		if($marker == FALSE) {
			echo 0;
		} else {
			echo $marker;	
		}
	}
}

function adminMarkers() {
	User::allowExecute(1);
	$results = MARKER::countAllMarkers();
	require(ADMIN_TEMPLATE . "markers/adminMarkers.php");
}

function adminSelect() {
	User::allowExecute(1);
	$districts = District::getDistrictList();
	$types = Type::getTypeList();
	if (isset($_POST['selectType'])) {
		header( "Location: markers.php?action=adminAdd&district=".$_POST['district_id']."&type=".$_POST['type_id'] );
	}
	require(ADMIN_TEMPLATE . "markers/adminSelect.php");
}

function adminDelSelect() {
	User::allowExecute(1);
	$districts = District::getDistrictList();
	$types = Type::getTypeList();
	if (isset($_POST['selectType'])) {
		header( "Location: markers.php?action=adminDel&district=".$_POST['district_id']."&type=".$_POST['type_id'] );
	}
	require(ADMIN_TEMPLATE . "markers/adminDelSelect.php");
}

?>