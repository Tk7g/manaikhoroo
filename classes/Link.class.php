<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");
define('TABLE_LINKS', "kh_links");

class Link {
	
	public static function getList() {
    	$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title, link FROM ".TABLE_LINKS." 
				ORDER BY ".TABLE_LINKS.".created DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
  	}
	
	public static function addLink($link) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $link['title']; 
		$data['link'] = $link['link'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$link_id = $db->query_insert(TABLE_LINKS, $data);
		$db->close();
		return $link_id;
	}
	
	public static function editLink($link) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $link['title']; 
		$data['link'] = $link['link'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$db->query_update(TABLE_LINKS, $data, "id='".$link['id']."'");
		$db->close();
	}
	
	public static function deleteLink($linkid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM ".TABLE_LINKS." WHERE id='".$linkid."'";
		$link_del = $db->query($sql);
		$db->close();
		return $link_del;
	}
	
	public static function getLink($linkid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_LINKS." WHERE id=".$linkid;
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
} 

?>