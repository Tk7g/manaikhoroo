<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Risks {
	
	public static function calculateArea($section) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['area'] = $section['area']; 
		$db->query_update("kh_risks", $data, "id='".$section['id']."'");
		$db->close();
	}
	
	public static function getCityRisks() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_risks ORDER BY title ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getDistrictRisks($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_risks
				WHERE district_id LIKE ".$district." ORDER BY title ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getRegionRisks($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_risks
				WHERE region_id LIKE ".$region." ORDER BY title ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getRegionRisks2015($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_risks
				WHERE region_id LIKE ".$region." AND created > '2015-12-31 00:00:00' ORDER BY title ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getRisksBorder($section) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT coordinate FROM kh_risks
				WHERE id LIKE ".$section."";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_risks.*, kh_districts.title as districtTitle, kh_districts.id as districtId, kh_regions.title as regionTitle, kh_regions.id as regionId 
				FROM kh_risks 
				LEFT JOIN kh_districts ON kh_risks.district_id=kh_districts.id
				LEFT JOIN kh_regions ON kh_risks.region_id=kh_regions.id
				ORDER BY kh_risks.created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function deleteRisks($sectionid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_risks WHERE id='".$sectionid."'";
		$section = $db->query($sql);
		$db->close();
		return $section;
	}
	
	public static function getRegionList($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_risks.*, kh_districts.title as districtTitle, kh_districts.id as districtId, kh_regions.title as regionTitle, kh_regions.id as regionId 
				FROM kh_risks 
				LEFT JOIN kh_districts ON kh_risks.district_id=kh_districts.id
				LEFT JOIN kh_regions ON kh_risks.region_id=kh_regions.id
				WHERE kh_risks.region_id = ".$region."
				ORDER BY kh_risks.created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getRegionList2015($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_risks.*, kh_districts.title as districtTitle, kh_districts.id as districtId, kh_regions.title as regionTitle, kh_regions.id as regionId 
				FROM kh_risks 
				LEFT JOIN kh_districts ON kh_risks.district_id=kh_districts.id
				LEFT JOIN kh_regions ON kh_risks.region_id=kh_regions.id
				WHERE kh_risks.region_id = ".$region." AND kh_risks.created > '2015-12-31 00:00:00'
				ORDER BY kh_risks.created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function saveRisks($section) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $section['title']; 
        $data['year'] = $section['year']; 
        $data['area'] = floatval($section['area']); 
		$data['district_id'] = $section['district_id'];
		$data['region_id'] = $section['region_id'];
		$data['coordinate'] = $section['coordinate'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$section_id = $db->query_insert("kh_risks", $data);
		$db->close();
		return $section_id;
	}
	
}

?>