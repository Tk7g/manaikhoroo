<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php");
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Region {

	public static function getRegionList($district_id) {
    	$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title, image FROM kh_regions
				WHERE district_id = '".$district_id['district_id']."'
				ORDER BY kh_regions.title ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
  	}
  	
  	public static function RegionList($district_id) {
    	$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title, image FROM kh_regions
				WHERE district_id = '".$district_id."'
				ORDER BY kh_regions.title ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
  	}

	public static function getRegion($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title, district_id, image, center, zoom, area_length FROM kh_regions WHERE id = ".$region;
		$result = $db->query_first($sql);
		$db->close();
		return $result;
	}

}

?>