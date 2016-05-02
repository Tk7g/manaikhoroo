<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class ProductType {
	
	public static function deleteProduct($product) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM hu_product_types WHERE id='".$product."'";
		$article = $db->query($sql);
		$db->close();
		return $article;
	}
	
	public static function addProduct($product) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $product['title']; 
		if($product['parent'] == 0) {
			
		} else {
			$data['parent'] = $product['parent'];
		}
		$data['queue'] = $product['queue'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("hu_product_types", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function editProduct($product) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $product['title']; 
		if($product['parent'] == 0) {
			
		} else {
			$data['parent'] = $product['parent'];
		}
		$data['queue'] = $product['queue'];
		$data['modified'] = date('Y-m-d H:i:s');
		$db->query_update("hu_product_types", $data, "id='".$product['id']."'");
		$db->close();
	}

	public static function getParentList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_product_types WHERE parent IS NULL ORDER BY queue ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getChildList($parent) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_product_types WHERE parent = ".$parent." ORDER BY queue ASC";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getProductType($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_product_types WHERE id = '".$id."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
} 

?>