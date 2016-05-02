<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/News.class.php");
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
		newsList();
}

function delete() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		$current_news = News::deleteNews((int)$_GET['id']);
		if($current_news == 0) {
			header( "Location: news.php?status=error" );
		} else {
			header( "Location: news.php?status=deleteSuccess" );	
		}
	} else {
		header("Location: index.php");	
	}
}

function edit() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		$current_news = News::getCurrentNews((int)$_GET['id']);
		if(isset($_POST['saveNews'])) {
			News::editNews($_POST);
			header( "Location: news.php?status=newsSaved" );
		}
		$categories = News::getCategories();
		$page_title = 'Мэдээ засварлах';
		require(ADMIN_WEB_TEMPLATE . "news/webEdit.php");
	} else {
		header("Location: index.php");
	}
}

function add() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		if (isset($_POST['saveNews'])) {
			$news_id = News::addNews($_POST);
			if($news_id == FALSE) {
				header( "Location: news.php?status=error" );
			} else {
				header( "Location: news.php?status=newsSaved" );	
			}
		}
		$categories = News::getCategories();
		$page_title = 'Мэдээ нэмэх';
		require(ADMIN_WEB_TEMPLATE . "news/webAdd.php");
	} else {
		header( "Location: index.php?action=home" );
	}
}

function newsList() {
	$detect = new Mobile_Detect();
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		if ( isset( $_GET['status'] ) ) {
    		if ( $_GET['status'] == "newsSaved" ) $result = "Мэдээ амжилттай хадгалагдлаа.";
    		if ( $_GET['status'] == "error" ) $result = "Алдаа гарсан тул дахин оролдоно уу.";
    		if ( $_GET['status'] == "deleteSuccess" ) $result = "Мэдээ устгагдлаа.";
  		}
  		$page_title = 'Мэдээ, мэдээлэл';
  		if(isset($_GET['page'])) {
			if($_GET['page'] == 1) {
				$data = News::getList(0, 10);
			} elseif($_GET['page'] > 1) {
				$from = ($_GET['page'] - 1)*10;
				$data = News::getList($from, 10);
			}
		} else {
			$data = News::getList(0, 10);
		}
		$total_pages = Page::getTotalRows("hu_news");
		$total_pagination = ceil($total_pages['COUNT(*)']/10);
	} else {
		header( "Location: index.php?action=home" );
	}
	if($detect->isMobile()) {
		require(ADMIN_TEMPLATE . "news/mobileList.php");	
	} else {
		require(ADMIN_WEB_TEMPLATE . "news/webList.php");
	}
}

function getCategoryName($catId) {
	$category = News::getCategory($catId);
	return $category['title'];
}

?>