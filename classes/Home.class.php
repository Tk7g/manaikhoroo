<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Home {

	public static function homeView($year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_districts ORDER BY title";
		$results['districts'] = $db->fetch_all_array($sql);
		$sql = "SELECT * FROM kh_types ORDER BY queue";
		$results['types'] = $db->fetch_all_array($sql);
		/*foreach($results['districts'] as $district) {
			$sql = "SELECT * FROM kh_infos WHERE district_id IS NOT NULL AND region_id IS NULL AND year LIKE ".$results['year']['year']."";
			$results['district_infos'][$district['id']] = $db->query_first($sql);
		}*/
		$sql = "SELECT * FROM kh_infos WHERE district_id IS NULL AND region_id IS NULL AND year LIKE ".$results['year']['year'];
		$results['city'] = $db->query_first($sql);
		foreach($results['districts'] as $district) {
			$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district['id']." AND region_id IS NULL AND year LIKE ".$results['year']['year'];
			$results[$district['id']]['info'] = $db->query_first($sql);
		}
		$db->close();
		return $results;
	}


} 

?>