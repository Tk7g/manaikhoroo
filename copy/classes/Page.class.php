<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Page {

	public static function getTotalRows($table) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM $table";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getNewsTotalRows($category) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM hu_news WHERE category_id = '".$category."' ";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getDirectOrderTotalRows() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM hu_orders WHERE company_id IS NULL";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getCompanyOrderTotalRows() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM hu_orders WHERE company_id IS NOT NULL";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getCompanyOrderFactoryTotalRows() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM hu_orders WHERE company_id IS NOT NULL AND status >= 4";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getDirectOrderFactoryTotalRows() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM hu_orders WHERE company_id IS NULL AND status >= 4";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
} 

?>