<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");
require_once('/../pdf/pdf/tcpdf.php');

class PdfMaker extends TCPDF {
	
	public function CityData($year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE year LIKE ".$year."";
		$data['year'] = $db->query_first($sql);
		$sql = "SELECT * FROM kh_districts ORDER BY id ASC";
		$data['districts'] = $db->fetch_all_array($sql);
		$sql = "SELECT * FROM kh_infos WHERE year LIKE ".$year." AND district_id IS NULL AND region_id IS NULL";
		$data['city_info'] = $db->query_first($sql);
		foreach($data['districts'] as $district) {
			$sql = "SELECT * FROM kh_infos WHERE year LIKE ".$year." AND district_id LIKE ".$district['id']." AND region_id IS NULL";
			$data[$district['id']]['info'] = $db->query_first($sql);
		}
		$db->close();
		return $data;
	}
	
}

?>