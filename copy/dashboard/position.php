<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Position.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Page.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Mobile_Detect.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'add' :
		add();
		break;
	case 'edit':
		edit();
		break;
	case 'delete':
		delete();
		break;
	default:
		positionList();
}

function delete() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		$current_news = Position::deletePosition((int)$_GET['id']);
		if($current_news == 0) {
			header( "Location: position.php?status=error" );
		} else {
			header( "Location: position.php?status=deleteSuccess" );	
		}
	} else {
		header("Location: index.php");	
	}
}

function edit() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		$current_position = Position::getPosition((int)$_GET['id']);
		if(isset($_POST['savePosition'])) {
			Position::editPosition($_POST);
			header( "Location: position.php?status=newsSaved" );
		}
		$page_title = 'Албан тушаал засварлах';
		require(ADMIN_WEB_TEMPLATE . "position/edit.php");
	} else {
		header("Location: index.php");
	}
}

function add() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		if (isset($_POST['savePosition'])) {
			$news_id = Position::addPosition($_POST);
			if($news_id == FALSE) {
				header( "Location: position.php?status=error" );
			} else {
				header( "Location: position.php?status=newsSaved" );	
			}
		}
		$page_title = 'Албан тушаал нэмэх';
		require(ADMIN_WEB_TEMPLATE . "position/add.php");
	} else {
		header( "Location: index.php?action=home" );
	}
}

function positionList() {
	$detect = new Mobile_Detect();
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		if ( isset( $_GET['status'] ) ) {
    		if ( $_GET['status'] == "newsSaved" ) $result = "Албан тушаал амжилттай хадгалагдлаа.";
    		if ( $_GET['status'] == "error" ) $result = "Алдаа гарсан тул дахин оролдоно уу.";
    		if ( $_GET['status'] == "deleteSuccess" ) $result = "Албан тушаал устгагдлаа.";
  		}
  		$page_title = 'Албан тушаал';
  		$data = Position::positionList();
	} else {
		header( "Location: index.php?action=home" );
	}
	if($detect->isMobile()) {
		
	} else {
		require(ADMIN_WEB_TEMPLATE . "position/list.php");
	}
}

?>