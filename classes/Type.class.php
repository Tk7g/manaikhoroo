<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Type {
	
	public static function getType($typeId) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_types WHERE id=".$typeId;
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public function editType($type, $file) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $type['title']; 
		$data['group_type'] = $type['group_type']; 
		$data['queue'] = $type['queue'];
		if(file_exists($file['image']['tmp_name'])) {
			$data['image'] =  $this->file_attachment($file['image']);
		}
		$data['modified'] = date('Y-m-d H:i:s');
		$db->query_update("kh_types", $data, "id='".$type['id']."'");
		$db->close();
	}
	
	public function addType($type, $file) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $type['title']; 
		$data['group_type'] = $type['group_type']; 
		$data['queue'] = $type['queue'];
		if(file_exists($file['image']['tmp_name'])) {
			$data['image'] =  $this->file_attachment($file['image']);	
		}
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("kh_types", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function deleteType($typeid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_types WHERE id='".$typeid."'";
		$menu = $db->query($sql);
		$db->close();
		return $menu;
	}
	
	function file_attachment($file) {
		$file_extension = pathinfo($file['name']);
		$new_name = rand(100, 999).'_'.date('YmdHis').'.'.$file_extension['extension'];
		move_uploaded_file($file['tmp_name'], realpath(dirname(__FILE__)).'/../webroot/types/'.$new_name);
		return 'http://manaikhoroo.ub.gov.mn/webroot/types/'.$new_name;
	}
	
	public static function getTypeList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_types ORDER BY queue ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getGroupTypeList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM group_types ORDER BY id ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getGroupType($typeId) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM group_types WHERE id=".$typeId;
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
}