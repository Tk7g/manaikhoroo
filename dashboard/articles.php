<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require(realpath(dirname(__FILE__))."/../classes/Article.class.php");

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
		newsList();
}

function delete() {
	if($_SESSION['login']['group_id'] == 1) {
		$current_user = Article::getArticle((int)$_GET['id']);
		$user_id = Article::deleteArticle($current_user['id']);
		if($user_id == 0) {
			header( "Location: articles.php?status=deleteUnsuccess" );
		} else {
			header( "Location: articles.php?status=deleteSuccess" );	
		}
	} else {
		header("Location: index.php");	
	}
}

function edit() {
	if($_SESSION['login']['group_id'] == 1) {
		$current_news = Article::getArticle((int)$_GET['id']);
		if(isset($_POST['saveNews'])) {
			Article::editArticle($_POST);
			header( "Location: articles.php?status=newsSaved" );
		}
		require(ADMIN_TEMPLATE . "news/newsEdit.php");
	} else {
		header("Location: index.php");
	}
}

function add() {
	if($_SESSION['login']['group_id'] == 1) {
		if (isset($_POST['saveNews'])) {
			$news_id = Article::addArticle($_POST);
			if($news_id == FALSE) {
				header( "Location: articles.php?status=saveUnsuccess" );
			} else {
				header( "Location: articles.php?status=newsSaved" );	
			}
		}
		require(ADMIN_TEMPLATE . "news/newsAdd.php");
	} else {
		header("Location: index.php");	
	}
}

function newsList() {
if($_SESSION['login']['group_id'] == 1) {
	$results = array();
	$data = Article::getList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "newsSaved" ) $results['statusMessage'] = "Мэдээ амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "saveUnsuccess" ) $results['statusMessage'] = "Хадгалах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Хэрэглэгч амжилттай устгагдлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['statusMessage'] = "Устгах явцад алдаа гарсан тул дахин оролдоно уу.";
  	}
	require( ADMIN_TEMPLATE . "news/newslist.php" );
} else {
	header("Location: index.php");	
}
}

?>