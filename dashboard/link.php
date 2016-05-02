<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require(realpath(dirname(__FILE__))."/../classes/Link.class.php");

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
		linkList();
}

function delete() {
	if($_SESSION['login']['group_id'] == 1) {
		$current_link = Link::getLink((int)$_GET['id']);
		$link_id = Link::deleteLink($current_link['id']);
		if($link_id == 0) {
			header( "Location: link.php?status=deleteUnsuccess" );
		} else {
			header( "Location: link.php?status=deleteSuccess" );	
		}
	} else {
		header("Location: index.php");	
	}
}

function linkList() {
	if($_SESSION['login']['group_id'] == 1) {
		$results = array();
		$data = Link::getList();
		if ( isset( $_GET['status'] ) ) {
    		if ( $_GET['status'] == "linkSaved" ) $results['statusMessage'] = "Холбоос амжилттай хадгалагдлаа.";
    		if ( $_GET['status'] == "saveUnsuccess" ) $results['statusMessage'] = "Хадгалах явцад алдаа гарлаа.";
    		if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Холбоос амжилттай устгагдлаа.";
    		if ( $_GET['status'] == "deleteUnsuccess" ) $results['statusMessage'] = "Устгах явцад алдаа гарсан тул дахин оролдоно уу.";
  		}
		require( ADMIN_TEMPLATE . "links/linklist.php" );
	} else {
		header("Location: index.php");	
	}
}

function edit() {
	if($_SESSION['login']['group_id'] == 1) {
		$current_link = Link::getLink((int)$_GET['id']);
		if(isset($_POST['saveLink'])) {
			Link::editLink($_POST);
			header( "Location: link.php?status=linkSaved" );	
		}
		require(ADMIN_TEMPLATE . "links/linkEdit.php");
	} else {
		header("Location: index.php");	
	}
}

function add() {
	if($_SESSION['login']['group_id'] == 1) {
		if (isset($_POST['saveLink'])) {
			$user_id = Link::addLink($_POST);
			if($user_id == 0) {
				header( "Location: link.php?status=saveUnsuccess" );
			} else {
				header( "Location: link.php?status=linkSaved" );	
			}
		}
		require(ADMIN_TEMPLATE . "links/linkAdd.php");
	} else {
		header("Location: index.php");	
	}
}

?>