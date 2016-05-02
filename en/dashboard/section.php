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
	default:
		sectionList();
}

function sectionDelete() {
	User::allowExecute(1);
	$section = Section::deleteSection($_GET['id']);
	if($section == 0) {
		header( "Location: section.php?status=deleteUnsuccess" );
	} else {
		header( "Location: section.php?status=deleteSuccess" );	
	}
}

function sectionDraw() {
	User::allowExecute(1);
	$region = Region::getRegion($_GET['region']);
	$district = District::getDistrict($_GET['district']);
	$sections = Section::getRegionSections($_GET['region']);
	if (isset($_POST['saveSection'])) {
		$section = Section::saveSection($_POST);
		if($section == FALSE) {
			header( "Location: section.php?status=unSuccess" );
		} else {
			header( "Location: section.php?status=sectionSaved" );
		}
	}
	require(ADMIN_TEMPLATE . "sections/sectionDraw.php");
}

function SectionBorder() {
	User::allowExecute(1);
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