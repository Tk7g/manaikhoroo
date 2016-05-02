<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'draw':
		sectionDraw();
		break;
	case 'add':
		sectionAdd();
		break;
	case 'delete':
		sectionDelete();
		break;
	case 'sectionBorder':
		sectionBorder();
		break;
	case 'sectionListRegion':
		sectionListRegion();
		break;
	case 'regionSelect':
		regionSelect();
		break;
	case 'regionSections':
		regionSections();
		break;
	case 'sectionConfirm':
		sectionConfirm();
		break;
	case 'sectionCancel':
		sectionCancel();
		break;
	case 'sectionCalculate':
		sectionCalculate();
		break;
	case 'calculateArea':
		calculateArea();
		break;
	case 'regionAreaLength':
		regionAreaLength();
		break;
	default:
		sectionList();
}

function calculateArea() {
	$section = Section::calculateArea($_POST);
}

function sectionCalculate() {
	User::allowExecute(array(1,3));
	//$sections = Section::getRegionSections($_GET['region']);
	$districts = District::getDistrictList();
	require(ADMIN_TEMPLATE . "sections/sectionCalculate.php");
}

function sectionCancel() {
	User::allowExecute(2);
	Section::cancelSection($_GET['section']);
	header("Location: section.php?action=regionSections&region=".$_GET['region']."&district=".$_GET['district']);
}

function sectionConfirm() {
	User::allowExecute(2);
	Section::confirmSection($_GET['section']);
	header("Location: section.php?action=regionSections&region=".$_GET['region']."&district=".$_GET['district']);
}

function regionSelect() {
	User::allowExecute(2);
	$regions = Region::getRegionList($_SESSION['login']['district_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	if (isset($_POST['selectRegion'])) {
		header("Location: section.php?action=regionSections&region=".$_POST['region_id']."&district=".$_SESSION['login']['district_id']);
	}
	require(ADMIN_TEMPLATE . "sections/regionSelect.php");
}

function regionSections() {
	User::allowExecute(2);
	$region = Region::getRegion($_GET['region']);
	$district = District::getDistrict($_GET['district']);
	$sections = Section::getRegionSections($_GET['region']);
	require(ADMIN_TEMPLATE . "sections/regionSections.php");
}

function sectionDelete() {
	User::allowExecute(1);
	$current_section = Section::getSec($_GET['id']);
	$section = Section::deleteSection($_GET['id']);
	if($section == 0) {
		header( "Location: section.php?action=sectionListRegion&district=".$current_section['district_id']."&region=".$current_section['region_id']."&status=deleteUnsuccess" );
	} else {
		header( "Location: section.php?action=sectionListRegion&district=".$current_section['district_id']."&region=".$current_section['region_id']."&status=deleteSuccess" );
	}
}

function regionAreaLength() {
	User::allowExecute(array(1,3));
	$region = Region::getRegion($_GET['region']);
	$district = District::getDistrict($_GET['district']);
	require(ADMIN_TEMPLATE . "sections/regionAreaLength.php");
}

function sectionDraw() {
	User::allowExecute(array(1,3));
	$region = Region::getRegion($_GET['region']);
	$district = District::getDistrict($_GET['district']);
	$sections = Section::getRegionSections($_GET['region']);
	if (isset($_POST['saveSection'])) {
		$section = Section::saveSection($_POST);
		if($section == FALSE) {
			if($_SESSION['login']['group_id'] == 3) {
				header( "Location: section.php?action=sectionListRegion&district=".$_SESSION['login']['district_id']."&region=".$_SESSION['login']['region_id']."&status=unSuccess" );
			} else {
				header( "Location: section.php?status=unSuccess" );	
			}
		} else {
			if($_SESSION['login']['group_id'] == 3) {
				header( "Location: section.php?action=sectionListRegion&district=".$_SESSION['login']['district_id']."&region=".$_SESSION['login']['region_id']."&status=sectionSaved" );
			} else {
				header( "Location: section.php?status=sectionSaved" );	
			}
		}
	}
	require(ADMIN_TEMPLATE . "sections/sectionDraw.php");
}

function SectionBorder() {
	User::allowExecute(array(1,2,3));
	$results = Section::getSectionBorder($_GET['section']);
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

function sectionAdd() {
	User::allowExecute(1);
	$districts = District::getDistrictList();
	if (isset($_POST['selectRegion'])) {
		header( "Location: section.php?action=draw&district=".$_POST['district_id']."&region=".$_POST['region_id'] );	
	}
	require(ADMIN_TEMPLATE . "sections/sectionAdd.php");
}

function sectionListRegion() {
	User::allowExecute(array(3));
	$results = array();
	$data = Section::getSectionList($_SESSION['login']['region_id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "sectionSaved" ) $results['statusMessage'] = "Хорооны хэсэг амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unSuccess" ) $results['statusMessage'] = "Алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['deleteUnsuccess'] = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['deleteSuccess'] = "Амжилттай устгагдлаа.";
  	}
  	$districtHeader = District::getDistrict($_SESSION['login']['district_id']);
	$regionHeader = Region::getRegion($_SESSION['login']['region_id']);
	require( ADMIN_TEMPLATE . "sections/sectionList.php" );
}

function sectionList() {
	User::allowExecute(array(1));
	$results = array();
	$data = Section::getList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "sectionSaved" ) $results['statusMessage'] = "Хорооны хэсэг амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unSuccess" ) $results['statusMessage'] = "Алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['deleteUnsuccess'] = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['deleteSuccess'] = "Амжилттай устгагдлаа.";
  	}
	require( ADMIN_TEMPLATE . "sections/sectionList.php" );
}

?>