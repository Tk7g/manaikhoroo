<?php
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/News.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Mobile_Detect.php");
require_once(realpath(dirname(__FILE__))."/classes/Category.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Page.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'content':
		content();
		break;
	case 'singleContent':
		singleContent();
		break;
	default:
		newsList();
}

function singleContent() {
	$news = News::getNews($_GET['id']);
	$page_title = $news['title'];
	$detect = new Mobile_Detect();
	if($detect->isMobile()) {
		require(SITE_TEMPLATE."news/singleContent.php");
	} else {
		require(WEB_TEMPLATE."news/singleContent.php");
	}
}

function newsList() {
	$page_title = 'Мэдээ, мэдээлэл';
	if(isset($_GET['page'])) {
		if($_GET['page'] == 1) {
			$news = News::getNewsList(5, 0, 10);
		} elseif($_GET['page'] > 1) {
			$from = ($_GET['page'] - 1)*10;
			$news = News::getNewsList(5, $from, 10);
		}
	} else {
		$news = News::getNewsList(5, 0, 10);
	}
	$total_pages = Page::getNewsTotalRows(5);
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
	$detect = new Mobile_Detect();
	if($detect->isMobile()) {
		require(SITE_TEMPLATE."news/newsList.php");
	} else {
		require(WEB_TEMPLATE."news/newsList.php");
	}
}

function content() {
	$news = News::getCategorySingleNews($_GET['cat']);
	$page_title = $news['title'];
	require(SITE_TEMPLATE."news/content.php");
}



?>