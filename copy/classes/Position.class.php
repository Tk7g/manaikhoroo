<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Position {

	public static function positionList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_positions ORDER BY id ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function editPosition($position) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $position['title'];
		$data['modified'] = date('Y-m-d H:i:s');
		$db->query_update("hu_positions", $data, "id='".$position['id']."'");
		$db->close();
	}
	
	public static function deletePosition($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM hu_positions WHERE id='".$id."'";
		$article = $db->query($sql);
		$db->close();
		return $article;
	}
	
	public static function getPosition($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_positions WHERE id = '".$id."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function addPosition($position) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $position['title']; 
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("hu_positions", $data);
		$db->close();
		return $primary_id;
	}
	
} 

?>