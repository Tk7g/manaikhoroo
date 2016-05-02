<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class District {
	
	public static function getDistrictList() {
    	$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title, titlePosition, image FROM kh_districts
				ORDER BY kh_districts.title ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
  	}
	
	public static function getDistrict($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title, zoom, position, report_zoom, report_center FROM kh_districts WHERE id = ".$district;
		$result = $db->query_first($sql);
		$db->close();
		return $result;
	}
	
} 

?>