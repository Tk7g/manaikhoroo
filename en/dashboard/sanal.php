<?php
error_reporting(0);
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/Sanal.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case "reply":
		reply();
		break;
	case "closedRegion":
		closedRegion();
		break;
	case "repliedRegion":
		repliedRegion();
		break;
	case "notClosedList":
		notClosedList();
		break;
	case "closedList":
		closedList();
		break;
	case "fullView":
		fullView();
		break;
	case "repliedView":
		repliedView();
		break;
	default:
		home();
}

function fullView() {
	User::allowExecute(2);
	$sanal = Sanal::getInfo($_GET['id']);
	if($sanal['district_id'] != $_SESSION['login']['district_id']) {
		header("Location: sanal.php?action=notClosedList");
	}
	require( ADMIN_TEMPLATE . "sanal/fullView.php" );
}

function repliedView() {
	User::allowExecute(2);
	$sanal = Sanal::getInfo($_GET['id']);
	$reply = Sanal::getInfoAdmin($sanal['id']);
	if($sanal['district_id'] != $_SESSION['login']['district_id']) {
		header("Location: sanal.php?action=closedList");
	}
	require( ADMIN_TEMPLATE . "sanal/repliedView.php" );
}

function closedList() {
	User::allowExecute(2);
	$results = Sanal::districtClosedList($_SESSION['login']['district_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	require( ADMIN_TEMPLATE . "sanal/districtClosedList.php" );
}

function notClosedList() {
	User::allowExecute(2);
	$results = Sanal::districtList($_SESSION['login']['district_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	require( ADMIN_TEMPLATE . "sanal/districtList.php" );
}

function repliedRegion() {
	User::allowExecute(3);
	$sanal = Sanal::getInfo($_GET['id']);
	$reply = Sanal::getReply($sanal['id']);
	if($sanal['region_id'] != $_SESSION['login']['region_id']) {
		header("Location: sanal.php?action=home&status=notAuth");
	}
	require( ADMIN_TEMPLATE . "sanal/repliedRegion.php" );
}

function closedRegion() {
	User::allowExecute(3);
	$results = Sanal::regionClosedList($_SESSION['login']['region_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	$region = Region::getRegion($_SESSION['login']['region_id']);
	require( ADMIN_TEMPLATE . "sanal/regionClosedList.php" );
}

function reply() {
	User::allowExecute(3);
	$sanal = Sanal::getInfo($_GET['id']);
	if($sanal['region_id'] != $_SESSION['login']['region_id']) {
		header("Location: sanal.php?action=home&status=notAuth");
	}
	if (isset($_POST['replySanal'])) {
		$userid = User::getUser($_SESSION['login']['username']);
		$reply_id = Sanal::addReply($_POST, $userid['id']);
		if($reply_id == FALSE) {
			header( "Location: sanal.php?status=unsuccess" );
		} else {
			header( "Location: sanal.php?status=success" );	
		}
	}
	require( ADMIN_TEMPLATE . "sanal/reply.php" );
}

function home() {
	if($_SESSION != NULL) {
		if($_SESSION['login']['group_id'] == 3) {
			if ( isset( $_GET['status'] ) ) {
    			if ( $_GET['status'] == "notAuth" ) $result = "Та энэ хуудас руу орох эрхгүй байна.";
    			if ( $_GET['status'] == "success" ) $result = "Хариу амжилттай илгээгдлээ.";
    			if ( $_GET['status'] == "unsuccess" ) $result = "Илгээх явцад алдаа гарлаа.";
  			}
			$results = Sanal::regionList($_SESSION['login']['region_id']);
			$district = District::getDistrict($_SESSION['login']['district_id']);
			$region = Region::getRegion($_SESSION['login']['region_id']);
			require( ADMIN_TEMPLATE . "sanal/regionLists.php" );
		} else {
			header("Location: /index.php");
		}
	} else {
		header("Location: /index.php");
	}
}

?>