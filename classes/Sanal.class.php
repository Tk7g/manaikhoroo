<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/settings.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Sanal {
	
	public static function countSanals() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM kh_sanal";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function countSanalTypes($type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM kh_sanal WHERE sanaltype_id = $type";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getSanalTypes() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_sanaltype ORDER BY id ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getSanalList($district, $region, $type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sqlAdd = '';
		if($district != NULL) {
			$sqlAdd .= "AND district_id = $district ";
		}
		if($region != NULL) {
			$sqlAdd .= "AND region_id = $region ";
		}
		if($type != NULL) {
			$sqlAdd .= "AND sanaltype_id = $type ";
		}
		$sql = "SELECT * FROM kh_sanal WHERE user_id IS NOT NULL $sqlAdd ORDER BY created DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}

	public static function districtClosedList($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_sanal.*, kh_users.firstname, kh_users.lastname, kh_users.phone, kh_users.identity, kh_users.email, kh_sanaltype.title as type
				FROM kh_sanal
				LEFT JOIN kh_users ON kh_sanal.user_id=kh_users.id
				LEFT JOIN kh_sanaltype ON kh_sanal.sanaltype_id=kh_sanaltype.id
				WHERE kh_sanal.district_id = ".$district." AND kh_sanal.closed = 1
				ORDER BY kh_sanal.created DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}

	public static function districtList($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_sanal.*, kh_users.firstname, kh_users.lastname, kh_users.phone, kh_users.identity, kh_users.email, kh_sanaltype.title as type
				FROM kh_sanal
				LEFT JOIN kh_users ON kh_sanal.user_id=kh_users.id
				LEFT JOIN kh_sanaltype ON kh_sanal.sanaltype_id=kh_sanaltype.id
				WHERE kh_sanal.district_id = ".$district." AND kh_sanal.closed = 0
				ORDER BY kh_sanal.created DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}

	public static function addReply($reply, $userid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['sanal_id'] = $reply['sanal_id']; 
		$data['reply'] = $reply['reply']; 
		$data['user_id'] = $userid;
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$sanal['closed'] = 1;
		$closed = $db->query_update('kh_sanal', $sanal, "id='".$reply['sanal_id']."'");
		$primary_id = $db->query_insert('kh_reply', $data);
		$db->close();
		return $primary_id;
	}
	
	public static function replySeen($replyid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$reply['seen'] = 1;
		$result = $db->query_update('kh_reply', $reply, "id='".$replyid."'");
		$db->close();
		return $result;
	}
	
	public static function getReply($sanalid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_reply WHERE sanal_id = ".$sanalid;
		$result = $db->query_first($sql);
		$db->close();
		return $result;
	}
	
	public static function getInfoAdmin($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_sanal.*, kh_users.firstname, kh_users.lastname, kh_users.phone, kh_users.identity, kh_users.email, kh_sanaltype.title as type
				FROM kh_sanal
				LEFT JOIN kh_users ON kh_sanal.user_id=kh_users.id
				LEFT JOIN kh_sanaltype ON kh_sanal.sanaltype_id=kh_sanaltype.id
				WHERE kh_sanal.id = ".$id;
		$result = $db->query_first($sql);
		$db->close();
		return $result;
	}

	public static function getInfo($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_sanal.*, kh_users.firstname, kh_users.lastname, kh_users.phone, kh_users.identity, kh_users.email, kh_sanaltype.title as type, kh_districts.title as district, kh_regions.title as region
				FROM kh_sanal
				LEFT JOIN kh_districts ON kh_sanal.district_id=kh_districts.id
				LEFT JOIN kh_regions ON kh_sanal.region_id=kh_regions.id
				LEFT JOIN kh_users ON kh_sanal.user_id=kh_users.id
				LEFT JOIN kh_sanaltype ON kh_sanal.sanaltype_id=kh_sanaltype.id
				WHERE kh_sanal.id = ".$id;
		$result = $db->query_first($sql);
		$db->close();
		return $result;
	}

	public static function regionList($regionid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_sanal.*, kh_users.firstname, kh_users.lastname, kh_users.phone, kh_users.identity, kh_users.email, kh_sanaltype.title as type
				FROM kh_sanal
				LEFT JOIN kh_users ON kh_sanal.user_id=kh_users.id
				LEFT JOIN kh_sanaltype ON kh_sanal.sanaltype_id=kh_sanaltype.id
				WHERE kh_sanal.region_id = ".$regionid." AND kh_sanal.closed = 0";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function regionClosedList($regionid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_sanal.*, kh_users.firstname, kh_users.lastname, kh_users.phone, kh_users.identity, kh_users.email, kh_sanaltype.title as type
				FROM kh_sanal
				LEFT JOIN kh_users ON kh_sanal.user_id=kh_users.id
				LEFT JOIN kh_sanaltype ON kh_sanal.sanaltype_id=kh_sanaltype.id
				WHERE kh_sanal.region_id = ".$regionid." AND kh_sanal.closed = 1";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function mySanalReply($sanalid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_reply WHERE sanal_id = ".$sanalid;
		$result = $db->query_first($sql);
		$db->close();
		return $result;
	}

	public static function myList($userid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_sanal.*, kh_sanaltype.title as type 
				FROM kh_sanal 
				LEFT JOIN kh_sanaltype ON kh_sanal.sanaltype_id=kh_sanaltype.id
				WHERE kh_sanal.user_id = ".$userid." 
				ORDER BY kh_sanal.created DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public function sanalAdd($sanal, $file, $userid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['sanaltype_id'] = $this->clear($sanal['sanaltype_id']); 
		$data['district_id'] = $this->clear($sanal['district_id']);
		$data['region_id'] =  $this->clear($sanal['region_id']);
		$data['content'] =  $this->clear($sanal['content']);
		if(file_exists($file['file']['tmp_name'])) {
			$data['file'] =  $this->file_attachment($file['file']);	
		}
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$data['user_id'] = $userid;
		$primary_id = $db->query_insert("kh_sanal", $data);
		$db->close();
		return $primary_id;
	}
	
	function file_attachment($file) {
		$file_extension = pathinfo($file['name']);
		$new_name = rand(100, 999).'_'.date('YmdHis').'.'.$file_extension['extension'];
		move_uploaded_file($file['tmp_name'], 'webroot/attachment/'.$new_name);
		return $new_name;
	}
	
	function clear($message) {
		if(!get_magic_quotes_gpc()) {
			$message = addslashes($message);
		}
		$message = strip_tags($message);
		$message = htmlentities($message);
		return trim($message);
	} 
	
	public static function getType() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_sanaltype ORDER BY id ASC";
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function getDistricts() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_districts ORDER BY title ASC";
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
} 

?>