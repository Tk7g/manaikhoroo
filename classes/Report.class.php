<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Report {

	public static function getRegionInfo($district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_regions WHERE district_id = ".$district." ORDER BY title ASC";
		$results['regions'] = $db->fetch_all_array($sql);
		foreach($results['regions'] as $reg) {
			$sql = "SELECT * FROM kh_infos
					WHERE region_id = ".$reg['id']." AND year <= 2014";
			$results[$reg['id']] = $db->query_first($sql);
		}
		$db->close();
		return $results;
	}
	
	public static function markerRegionCount($type, $region, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM kh_markers
				WHERE type_id LIKE ".$type." AND region_id LIKE ".$region." AND year <= ".$year." AND published = 1";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function markerDistrictCount($type, $district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM kh_markers
				WHERE type_id LIKE ".$type." AND district_id LIKE ".$district." AND region_id IS NOT NULL AND year <= ".$year." AND published = 1";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public function getYearList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_years ORDER BY year DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public function getDistricts() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_districts ORDER BY title ASC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public function getRegions($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_regions WHERE district_id LIKE ".$district." ORDER BY title ASC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public function getYear() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_years WHERE used = 1";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public function cityInfo($year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE year <= ".$year." AND district_id IS NULL AND region_id IS NULL";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public function getMarkerCount($type, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_types.title as type, kh_types.image as image, COUNT(*)
				FROM kh_markers
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				WHERE year <= ".$year." AND type_id LIKE ".$type."";	
		$results = $db->query_first($sql);
		$db->close();
		return $results;	
	}
	
	public function getDistrictInfo($district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district." AND year LIKE ".$year." AND region_id IS NULL";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public function getDistrictMarker($district, $type, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_types.title as type, kh_types.image as image, COUNT(*)
				FROM kh_markers
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				WHERE year LIKE ".$year." AND type_id LIKE ".$type." AND district_id LIKE ".$district."";	
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public function markerTypes() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_types ORDER BY queue ASC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getSectionsPopDenstity($region, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE year LIKE ".$year." AND region_id LIKE ".$region." AND section_id != 0 ORDER BY population_density ASC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getRegionsPopDensity($district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE year LIKE ".$year." AND district_id LIKE ".$district." AND region_id IS NOT NULL AND section_id LIKE 0 ORDER BY population_density ASC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
}

?>