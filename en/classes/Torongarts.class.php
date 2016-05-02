<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Torongarts {
	
	public static function getRegionTorongarts($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_torongarts
				WHERE region_id LIKE ".$region." ORDER BY title ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getTorongartsBorder($section) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT coordinate FROM kh_torongarts
				WHERE id LIKE ".$section."";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_torongarts.*, kh_districts.title as districtTitle, kh_districts.id as districtId, kh_regions.title as regionTitle, kh_regions.id as regionId 
				FROM kh_torongarts 
				LEFT JOIN kh_districts ON kh_torongarts.district_id=kh_districts.id
				LEFT JOIN kh_regions ON kh_torongarts.region_id=kh_regions.id
				ORDER BY kh_torongarts.created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function deleteTorongarts($sectionid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_torongarts WHERE id='".$sectionid."'";
		$section = $db->query($sql);
		$db->close();
		return $section;
	}
	
	public static function saveTorongarts($section) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $section['title']; 
		$data['district_id'] = $section['district_id'];
		$data['region_id'] = $section['region_id'];
		$data['coordinate'] = $section['coordinate'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$section_id = $db->query_insert("kh_torongarts", $data);
		$db->close();
		return $section_id;
	}
	
}

?>