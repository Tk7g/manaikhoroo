<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Statistic {
	
	public static function countMonthVisit() {
		$db = new Database( ST_SERVER, ST_USER, ST_PASS, ST_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM stat_visits 
				WHERE MONTH(date) = MONTH(CURDATE())";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function countWeekVisit() {
		$db = new Database( ST_SERVER, ST_USER, ST_PASS, ST_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM stat_visits 
				WHERE YEARWEEK(date) = YEARWEEK(CURDATE())";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function countTodayVisit() {
		$db = new Database( ST_SERVER, ST_USER, ST_PASS, ST_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM stat_visits 
				WHERE date = CURDATE()";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function countAllVisit() {
		$db = new Database( ST_SERVER, ST_USER, ST_PASS, ST_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM stat_visits";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function countByMonthVisit($month, $year) {
		$db = new Database( ST_SERVER, ST_USER, ST_PASS, ST_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM stat_visits WHERE date BETWEEN '".$year."-".$month."-01' AND '".$year."-".$month."-31'";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function countByDayVisit($date, $month, $year) {
		$db = new Database( ST_SERVER, ST_USER, ST_PASS, ST_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM stat_visits WHERE date = '".$year."-".$month."-".$date."'";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function countByYearVisit($year) {
		$db = new Database( ST_SERVER, ST_USER, ST_PASS, ST_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM stat_visits WHERE date BETWEEN '".$year."-01-01' AND '".$year."-12-31'";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
} 

?>