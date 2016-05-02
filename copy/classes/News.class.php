<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class News {
	
	public static function getCategorySingleNews($category) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_news WHERE category_id = '".$category."' AND published = '1'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function getCurrentNews($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_news WHERE id = '".$id."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function getNews($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_news WHERE id = '".$id."' AND published = '1'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function getList($from, $limit) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_news ORDER BY created DESC LIMIT $from, $limit";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getNewsList($category, $from, $limit) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_news WHERE category_id = '".$category."' ORDER BY created DESC LIMIT $from, $limit";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getCategories() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_categories ORDER BY created DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getCategory($catId) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_categories WHERE id = '".$catId."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function editNews($news) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $news['title']; 
		$data['content'] = $news['content'];
		$data['category_id'] = $news['category_id'];
		$data['published'] = $news['published'];
		$data['modified'] = date('Y-m-d H:i:s');
		$db->query_update("hu_news", $data, "id='".$news['id']."'");
		$db->close();
	}
	
	public static function addNews($news) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $news['title']; 
		$data['content'] = $news['content'];
		$data['category_id'] = $news['category_id'];
		$data['published'] = $news['published'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("hu_news", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function deleteNews($news) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM hu_news WHERE id='".$news."'";
		$article = $db->query($sql);
		$db->close();
		return $article;
	}
	
} 

?>