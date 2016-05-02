<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Menu {
	
	public static function getSubs($menuid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_menus WHERE sub = ".$menuid." ORDER BY queue ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}

	public static function getParents() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_menus WHERE sub IS NULL ORDER BY queue ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public function addMenu($menu, $file) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $menu['title']; 
		$data['component'] = $menu['component'];
		$data['queue'] = $menu['queue'];
		if(isset($menu['additional'])) {
			$data['additional'] = $menu['additional'];
		}
		if($menu['sub'] != NULL) {
			$data['sub'] = $menu['sub'];
		}
		if(file_exists($file['image']['tmp_name'])) {
			$data['image'] =  $this->file_attachment($file['image']);	
		}
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("kh_menus", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function deleteMenu($menuid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_menus WHERE id='".$menuid."'";
		$menu = $db->query($sql);
		$db->close();
		return $menu;
	}
	
	function file_attachment($file) {
		$file_extension = pathinfo($file['name']);
		$new_name = rand(100, 999).'_'.date('YmdHis').'.'.$file_extension['extension'];
		move_uploaded_file($file['tmp_name'], realpath(dirname(__FILE__)).'/../webroot/menu/'.$new_name);
		return $new_name;
	}
	
	public static function getMenuList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_menus ORDER BY queue ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
}