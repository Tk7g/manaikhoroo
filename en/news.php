<?php
error_reporting(0);
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Link.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Article.class.php");
include(SITE_TEMPLATE. "header.php");

$page = isset( $_GET['page'] ) ? $_GET['page'] : "";

switch ( $page ) {
	case 'view' :
		view();
		break;
	case 'info' :
		info();
		break;
	default:
		newsList();
}

function newsList() {
	$news = Article::getList(2);
	require( SITE_TEMPLATE . "news/newslist.php" );
}

function view() {
	$news = Article::getArticle($_GET['id']);
	require( SITE_TEMPLATE . "news/view.php" );
}

function info() {
	$news = Article::getArticle($_GET['id']);
	require( SITE_TEMPLATE . "news/info.php" );
}

?>


<?php
include(SITE_TEMPLATE. "footer.php");
?>