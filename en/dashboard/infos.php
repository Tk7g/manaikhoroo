<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Year.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'add':
		add();
		break;
	case 'edit':
		edit();
		break;
	default:
		infoList();
}

function edit() {
	User::allowExecute(3);
	$info = Info::getInfo($_GET['id']);
	$years = Year::getYearList();
	if (isset($_POST['saveInfo'])) {
		if($_POST['section_id'] == 0) {
			$inf = new Info;
			$results = $inf->infoEdit($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST);
		} else {
			$results = Info::sectionInfoEdit($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST);
		}
		if($results == 0) {
			header( "Location: infos.php?status=saveUnsuccess" );
		} else {
			header( "Location: infos.php?status=infoSaved" );	
		}
	}
	$sections = Section::getRegionSections($_SESSION['login']['region_id']);
	require(ADMIN_TEMPLATE . "infos/infoEdit.php");
}

function add() {
	User::allowExecute(3);
	if (isset($_POST['saveInfo'])) {
		if($_POST['section_id'] == 0) {
			$info = new Info;
			$results = $info->infoAdd($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST);
		} else {
			$info = new Info;
			$results = $info->sectionInfoAdd($_SESSION['login']['district_id'], $_SESSION['login']['region_id'], $_POST);
		}
		if($results == 0) {
			header( "Location: infos.php?status=saveUnsuccess" );
		} else {
			header( "Location: infos.php?status=infoSaved" );	
		}
	}
	$sections = Section::getRegionSections($_SESSION['login']['region_id']);
	require(ADMIN_TEMPLATE . "infos/infoAdd.php");
}

function infoList() {
	User::allowExecute(3);
	$results = Info::infoRegionList($_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "infoSaved" ) $results['statusMessage'] = "Мэдээлэл амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "saveUnsuccess" ) $results['statusMessage'] = "Хадгалах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Мэдээлэл амжилттай устгагдлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['statusMessage'] = "Устгах явцад алдаа гарсан тул дахин оролдоно уу.";
  	}
	require(ADMIN_TEMPLATE . "infos/infoRegionList.php");
}

?>