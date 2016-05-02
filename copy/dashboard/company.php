<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Page.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Company.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Position.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Mobile_Detect.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'add':
		add();
		break;
	case 'edit':
		edit();
		break;
	case 'delete':
		delete();
		break;
	default:
		companyList();
}

function delete() {
	User::allowExecute(array(1,2));
	$current_company = Company::getCompany($_GET['id']);
	$result = Company::deleteCompany($current_company['id']);
	if($result == 0) {
		header( "Location: company.php?status=error" );
	} else {
		header( "Location: company.php?status=deleteSuccess" );
	}
}

function edit() {
	User::allowExecute(array(1,2));
	if (isset($_POST['saveCompany'])) {
		$result = Company::editCompany($_POST);
		if($result == 0) {
			header( "Location: company.php?status=error" );
		} else {
			header( "Location: company.php?status=editSuccess" );
		}
	}
	$company_info = Company::getCompany($_GET['id']);
	$positions = Position::positionList();
	$page_title = 'Гэрээт компани засварлах';
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "company/edit.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "company/edit.php");
	}
}

function add() {
	User::allowExecute(array(1,2));
	if (isset($_POST['saveCompany'])) {
		$result = Company::addCompany($_POST);
		if($result == 0) {
			header( "Location: company.php?status=error" );
		} else {
			header( "Location: company.php?status=success" );
		}
	}
	$positions = Position::positionList();
	$page_title = 'Гэрээт компани шинээр бүртгэх';
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "company/add.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "company/add.php");
	}
}

function companyList() {
	User::allowExecute(array(1,2));
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "success" ) $result = "Компаний бүртгэл амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "editSuccess" ) $result = "Компаний бүртгэл амжилттай засварлагдлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $result = "Компаний бүртгэл устгагдлаа.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
  	}
  	if(isset($_GET['page'])) {
		if($_GET['page'] == 1) {
			$companies = Company::companyList(0, 10);
		} elseif($_GET['page'] > 1) {
			$from = ($_GET['page'] - 1)*10;
			$companies = Company::companyList($from, 10);
		}
	} else {
		$companies = Company::companyList(0, 10);
	}
	$total_pages = Page::getTotalRows("hu_company_info");
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
  	$page_title = 'Гэрээт компаний бүртгэл';
  	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "company/companyList.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "company/list.php");
	}
}

?>