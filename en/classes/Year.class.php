<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Year {
	
	public static function getDefaultYear() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_years WHERE used LIKE 1";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}

	public static function getYearList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_years ORDER BY year DESC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function addYear($year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		if($year['used'] == 1) {
			$sql = "SELECT * FROM kh_years ORDER BY year DESC";
			$rows = $db->fetch_all_array($sql);
			foreach($rows as $rw) {
				$data_change['used'] = 0;
				$db->query_update("kh_years", $data_change, "id='".$rw['id']."'");
			}
		}
		$data['year'] = $year['year']; 
		$data['used'] = $year['used'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("kh_years", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function editYear($year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		if($year['used'] == 1) {
			$sql = "SELECT * FROM kh_years ORDER BY year DESC";
			$rows = $db->fetch_all_array($sql);
			foreach($rows as $rw) {
				$data_change['used'] = 0;
				$db->query_update("kh_years", $data_change, "id='".$rw['id']."'");
			}
		}
		$data['year'] = $year['year']; 
		$data['used'] = $year['used'];
		$data['modified'] = date('Y-m-d H:i:s');
		$db->query_update("kh_years", $data, "id='".$year['id']."'");
		$db->close();
	}
	
	public static function deleteYear($yearid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM kh_years WHERE id='".$yearid."'";
		$year = $db->query($sql);
		$db->close();
		return $year;
	}
	
	public static function getYear($yearid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_years WHERE id=".$yearid;
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
} 

?>