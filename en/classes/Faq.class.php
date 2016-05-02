<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");
define('TABLE_FAQ', "kh_faq");

class Faq {

	public static function getList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title, content FROM ".TABLE_FAQ."  
			ORDER BY ".TABLE_FAQ.".id ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getFaq($faqid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_FAQ." WHERE id=".$faqid;
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}

	public static function editFaq($faq) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $faq['title']; 
		$data['content'] = $faq['content'];
		$db->query_update(TABLE_FAQ, $data, "id='".$faq['id']."'");
		$db->close();
	}
	
} 

?>