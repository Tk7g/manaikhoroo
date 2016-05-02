<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Message {
	
	public static function sendToRegion($region, $message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect(); 
		$data['message_id'] = $message_id;
		$data['to_region_id'] = $region;
		$primary_id = $db->query_insert("kh_message_to", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function sendToDistrict($district, $message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect(); 
		$data['message_id'] = $message_id;
		$data['to_district_id'] = $district;
		$primary_id = $db->query_insert("kh_message_to", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function sendToAdmin($toAdmin, $message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect(); 
		$data['message_id'] = $message_id;
		$data['to_admin'] = $toAdmin;
		$primary_id = $db->query_insert("kh_message_to", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function sendMessage($message) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect(); 
		$data['text'] = $message['text'];
		$data['wrote'] = $message['wrote'];
		$data['created'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("kh_messages", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function districtUserSentMessages($user_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_messages
				WHERE wrote = $user_id ORDER BY created DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getRegionSentMessages($message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_message_to
				WHERE message_id = $message_id AND to_region_id IS NOT NULL ORDER BY to_region_id ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getDistrictSentMessages($message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_message_to
				WHERE message_id = $message_id AND to_district_id IS NOT NULL ORDER BY to_district_id ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getAdminSentMessages($message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_message_to
				WHERE message_id = $message_id AND to_admin IS NOT NULL";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getMessage($message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_messages WHERE id = $message_id";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function deleteMessage($message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_messages WHERE id = $message_id";
		$marker_id = $db->query($sql);
		$db->close();
		return $marker_id;
	}
	
	public static function deleteMessageTo($message_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_message_to WHERE id = $message_id";
		$marker_id = $db->query($sql);
		$db->close();
		return $marker_id;
	}
	
	public static function getDistrictInboxMessages($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_message_to
				WHERE to_district_id = $district ORDER BY id DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getRegionInboxMessages($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_message_to
				WHERE to_region_id = $region ORDER BY id DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getAdminInboxMessages() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_message_to
				WHERE to_admin = 1 ORDER BY id DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getDistrictNewInboxMessages($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM kh_message_to
				WHERE to_district_id = $district AND seen = 0 ORDER BY id DESC";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getRegionNewInboxMessages($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM kh_message_to
				WHERE to_region_id = $region AND seen = 0 ORDER BY id DESC";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getAdminNewInboxMessages() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM kh_message_to
				WHERE to_admin = 1 AND seen = 0 ORDER BY id DESC";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
} 

?>