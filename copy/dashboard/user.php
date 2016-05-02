<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Page.class.php");
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
		userList();
}

function delete() {
	User::allowExecute(array(1,2));
	$user_info = User::getUser($_GET['id']);
	$result = User::deleteUser($user_info['id']);
	if($result == 0) {
		header( "Location: user.php?status=error" );
	} else {
		header( "Location: user.php?status=deleteSuccess" );
	}
}

function edit() {
	User::allowExecute(array(1,2));
	if (isset($_POST['saveUser'])) {
		$result = User::editUser($_POST);
		if($result == 0) {
			header( "Location: user.php?status=error" );
		} else {
			header( "Location: user.php?status=editSuccess" );
		}
	}
	$user_info = User::getUser($_GET['id']);
	$page_title = 'Гэрээт компани засварлах';
	$detect = new Mobile_Detect();
	if($detect->isMobile()) {
 		require(require(ADMIN_TEMPLATE . "user/edit.php"));
  	} else {
		require(ADMIN_WEB_TEMPLATE . "user/edit.php");
	}
}

function add() {
	User::allowExecute(array(1,2));
	if (isset($_POST['saveUser'])) {
		$result = User::addUser($_POST);
		if($result == 0) {
			header( "Location: user.php?status=error" );
		} else {
			header( "Location: user.php?status=success" );
		}
	}
	$page_title = 'Системийн хэрэглэгч шинээр бүртгэх';
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(require(ADMIN_TEMPLATE . "user/add.php"));
  	} else {
		require(ADMIN_WEB_TEMPLATE . "user/add.php");
	}
}

function userList() {
	User::allowExecute(array(1,2));
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "success" ) $result = "Системийн хэрэглэгч амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "editSuccess" ) $result = "Системийн хэрэглэгч амжилттай засварлагдлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $result = "Системийн хэрэглэгч устгагдлаа.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
  	}
  	if(isset($_GET['page'])) {
		if($_GET['page'] == 1) {
			$users = User::userList(0, 10);
		} elseif($_GET['page'] > 1) {
			$from = ($_GET['page'] - 1)*10;
			$users = User::userList($from, 10);
		}
	} else {
		$users = User::userList(0, 10);
	}
	$total_pages = Page::getTotalRows("hu_users");
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
  	$page_title = 'Системийн хэрэглэгчид';
  	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "user/userList.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "user/userList.php");
	}
}

function getUserGroupName($groupId) {
	if($groupId == 2) {
		$groupName = 'Менежер';
	} elseif($groupId == 3) {
		$groupName = 'Үйлдвэрийн менежер';
	} 
	return $groupName;
}

?>