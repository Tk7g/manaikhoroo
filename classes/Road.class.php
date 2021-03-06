<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Road {
	
	public static function getDistrictRoads($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_roads
				WHERE district_id LIKE ".$district."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}

	public static function getRegionRoads($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_roads
				WHERE region_id LIKE ".$region."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getRegionRoads2015($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_roads
				WHERE region_id LIKE ".$region." AND created > '2015-12-31 00:00:00'";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function saveRoad($road) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $road['title']; 
		$data['location'] = $road['location']; 
		$data['info1'] = $road['info1']; 
		$data['info2'] = $road['info2']; 
		$data['info3'] = $road['info3']; 
		$data['year'] = $road['year']; 
		$data['district_id'] = $road['district_id'];
		$data['region_id'] = $road['region_id'];
		$data['coordinate'] = $road['coordinate'];
		$data['width'] = $road['info3'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$road_id = $db->query_insert("kh_roads", $data);
		$db->close();
		return $road_id;
	}
	
	public static function deleteRoad($roadid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_roads WHERE id='".$roadid."'";
		$road = $db->query($sql);
		$db->close();
		return $road;
	}
	
	
	public static function getList($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_roads.*, kh_districts.title as districtTitle, kh_districts.id as districtId, kh_regions.title as regionTitle, kh_regions.id as regionId 
				FROM kh_roads 
				LEFT JOIN kh_districts ON kh_roads.district_id=kh_districts.id
				LEFT JOIN kh_regions ON kh_roads.region_id=kh_regions.id
				WHERE kh_roads.region_id = $region
				ORDER BY kh_roads.created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getList2015($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_roads.*, kh_districts.title as districtTitle, kh_districts.id as districtId, kh_regions.title as regionTitle, kh_regions.id as regionId 
				FROM kh_roads 
				LEFT JOIN kh_districts ON kh_roads.district_id=kh_districts.id
				LEFT JOIN kh_regions ON kh_roads.region_id=kh_regions.id
				WHERE kh_roads.region_id = $region AND kh_roads.created > '2015-12-31 00:00:00'
				ORDER BY kh_roads.created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getRoadBorder($road) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT coordinate FROM kh_roads
				WHERE id LIKE ".$road."";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}

}

?>