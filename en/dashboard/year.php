<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require(realpath(dirname(__FILE__))."/../classes/Year.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'edit' :
		edit();
		break;
	case 'add':
    	add();
    	break;
	case 'delete':
		delete();
		break;
	default:
		yearList();
}

function delete() {
	if($_SESSION['login']['group_id'] == 1) {
		$current_year = Year::getYear((int)$_GET['id']);
		$year_id = Year::deleteYear($current_year['id']);
		if($year_id == 0) {
			header( "Location: year.php?status=deleteUnsuccess" );
		} else {
			header( "Location: year.php?status=deleteSuccess" );	
		}
	} else {
		header("Location: index.php");	
	}
}

function edit() {
	if($_SESSION['login']['group_id'] == 1) {
		$current_year = Year::getYear((int)$_GET['id']);
		if(isset($_POST['saveYear'])) {
			Year::editYear($_POST);
			header( "Location: year.php?status=yearSaved" );
		}
		require(ADMIN_TEMPLATE . "years/yearEdit.php");
	} else {
		header("Location: index.php");
	}
}

function add() {
	if($_SESSION['login']['group_id'] == 1) {
		if (isset($_POST['saveYear'])) {
			$year_id = Year::addYear($_POST);
			if($year_id == FALSE) {
				header( "Location: year.php?status=saveUnsuccess" );
			} else {
				header( "Location: year.php?status=yearSaved" );	
			}
		}
		require(ADMIN_TEMPLATE . "years/yearAdd.php");
	} else {
		header("Location: index.php");	
	}
}

function yearList() {
if($_SESSION['login']['group_id'] == 1) {
	$results = array();
	$data = Year::getYearList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "yearSaved" ) $results['statusMessage'] = "Он амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "saveUnsuccess" ) $results['statusMessage'] = "Хадгалах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Он амжилттай устгагдлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['statusMessage'] = "Устгах явцад алдаа гарсан тул дахин оролдоно уу.";
  	}
	require( ADMIN_TEMPLATE . "years/yearlist.php" );
} else {
	header("Location: index.php");	
}
}

?>