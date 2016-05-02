<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");
define('TABLE_NEWS', "kh_articles");

class Article {
	
	public static function getArticleList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_articles ORDER BY created DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getList($cat = NULL, $limit = NULL) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		if($limit == NULL && $cat == NULL) {
			$sql = "SELECT id, title, content, created FROM ".TABLE_NEWS."  
				ORDER BY ".TABLE_NEWS.".created DESC";
		} elseif($limit == NULL && $cat != NULL) {
			$sql = "SELECT id, title, content, created FROM ".TABLE_NEWS."
				WHERE category_id LIKE ".$cat."
				ORDER BY ".TABLE_NEWS.".created";
		} else {
			$sql = "SELECT id, title, content, created FROM ".TABLE_NEWS."
				WHERE category_id LIKE ".$cat."
				ORDER BY ".TABLE_NEWS.".created DESC LIMIT $limit";
		}
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getArticle($articleid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_NEWS." WHERE id=".$articleid;
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function deleteArticle($articleid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM ".TABLE_NEWS." WHERE id='".$articleid."'";
		$article = $db->query($sql);
		$db->close();
		return $article;
	}
	
	public static function editArticle($news) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $news['title']; 
		$data['content'] = $news['content'];
		$data['modified'] = date('Y-m-d H:i:s');
		$db->query_update(TABLE_NEWS, $data, "id='".$news['id']."'");
		$db->close();
	}
	
	public static function addArticle($news) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $news['title']; 
		$data['content'] = $news['content'];
		$data['category_id'] = 2;
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert(TABLE_NEWS, $data);
		$db->close();
		return $primary_id;
	}
	
} 

?>