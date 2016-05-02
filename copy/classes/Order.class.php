<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Order {
	
	public static function newCompanyOrders() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_orders WHERE company_id IS NOT NULL ORDER BY created DESC LIMIT 6";
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function getAgreementOrders($agreementId) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_orders WHERE agreement_id = '$agreementId' AND status != 3";
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function newDirectOrders() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_orders WHERE company_id IS NULL ORDER BY created DESC LIMIT 6";
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function getMyOrders($companyId, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_orders WHERE company_id = '".$companyId."' AND order_date BETWEEN '".$year."-01-01' AND '".$year."-12-31' ORDER BY id ASC";
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function getYearOrders($year, $month, $company) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		if($company == 2) {
			$sql = "SELECT * FROM hu_orders WHERE company_id IS NULL AND status != 3 AND order_date BETWEEN '".$year."-".$month."-01' AND '".$year."-".$month."-31' ORDER BY order_date ASC";
		} elseif($company == 1) {
			$sql = "SELECT * FROM hu_orders WHERE company_id IS NOT NULL AND status != 3 AND order_date BETWEEN '".$year."-".$month."-01' AND '".$year."-".$month."-31' ORDER BY order_date ASC";
		} else {
			$sql = "SELECT * FROM hu_orders WHERE status != 3 AND order_date BETWEEN '".$year."-".$month."-01' AND '".$year."-".$month."-31' ORDER BY order_date ASC";
		}
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function getDateOrders($date, $company) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		if($company == 2) {
			$sql = "SELECT * FROM hu_orders WHERE company_id IS NULL AND status != 3 AND order_date BETWEEN '".$date."' AND '".$date."' ORDER BY order_date ASC";
		} elseif($company == 1) {
			$sql = "SELECT * FROM hu_orders WHERE company_id IS NOT NULL AND status != 3 AND order_date BETWEEN '".$date."' AND '".$date."' ORDER BY order_date ASC";
		} else {
			$sql = "SELECT * FROM hu_orders WHERE status != 3 AND order_date BETWEEN '".$date."' AND '".$date."' ORDER BY order_date ASC";
		}
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function getCompanyYearOrders($companyId, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_orders WHERE company_id = '".$companyId."' AND status != 3 AND order_date BETWEEN '".$year."-01-01' AND '".$year."-12-31' ORDER BY created DESC";
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function getCompanyMonthOrders($companyId, $date1, $date2) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_orders WHERE company_id = '".$companyId."' AND status != 3 AND order_date BETWEEN '".$date1."' AND '".$date2."' ORDER BY order_date ASC";
		$row = $db->fetch_all_array($sql);
		$db->close();
		return $row;
	}
	
	public static function getCompanyOrderStatusAll($status, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM hu_orders WHERE company_id IS NOT NULL AND status = $status AND order_date BETWEEN '".$year."-01-01' AND '".$year."-12-31'";	
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getDirectOrderStatusAll($status, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*) FROM hu_orders WHERE company_id IS NULL AND status = $status AND order_date BETWEEN '".$year."-01-01' AND '".$year."-12-31'";	
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getOrder($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_orders WHERE id = '".$id."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function orderChecked($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['checked'] = 1;
		$primary_id = $db->query_update("hu_orders", $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
	public static function directOrderAll($from, $limit, $status, $product) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sqlAdd = "";
		if($status != NULL) {
			$sqlAdd .= "AND status = $status ";
		}
		if($product != NULL) {
			$sqlAdd .= "AND product_type_id = $product ";
		}
		$sql = "SELECT * FROM hu_orders WHERE company_id IS NULL $sqlAdd ORDER BY order_date DESC LIMIT $from, $limit";	
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function orderAll($from, $limit, $status, $company, $product) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sqlAdd = "";
		if($status != NULL) {
			$sqlAdd .= "AND status = $status ";
		}
		if($company != NULL) {
			$sqlAdd .= "AND company_id = $company ";
		}
		if($product != NULL) {
			$sqlAdd .= "AND product_type_id = $product ";
		}
		$sql = "SELECT * FROM hu_orders WHERE company_id IS NOT NULL $sqlAdd ORDER BY order_date DESC LIMIT $from, $limit";	
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function directOrderFactory($from, $limit, $product) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sqlAdd = "";
		if($product != NULL) {
			$sqlAdd .= "AND product_type_id = $product ";
		}
		$sql = "SELECT * FROM hu_orders WHERE company_id IS NULL AND status >= 4 $sqlAdd ORDER BY order_date DESC LIMIT $from, $limit";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function orderFactory($from, $limit, $company, $product) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sqlAdd = "";
		if($company != NULL) {
			$sqlAdd .= "AND company_id = $company ";
		}
		if($product != NULL) {
			$sqlAdd .= "AND product_type_id = $product ";
		}
		$sql = "SELECT * FROM hu_orders WHERE company_id IS NOT NULL AND status >= 4 $sqlAdd ORDER BY order_date DESC LIMIT $from, $limit";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public function directOrder($order) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['company_name'] = $order['company_name'];
		$data['client_name'] = $order['client_name'];
		$data['position_id'] = $order['position_id'];
		$data['product_type_id'] = $order['product_type_id'];
		$data['payment_status'] = $order['payment_status'];
		$data['pomp_type_id'] = $order['pomp_type_id'];
		$data['size1'] = $order['size1'];
		$data['size2'] = $order['size2'];
		$data['concrete_type_id'] = $order['concrete_type_id'];
		$data['slump_type_id'] = $order['slump_type_id'];
		$data['order_date'] = $order['order_date'];
		$data['order_time'] = $order['order_time'];
		$data['phone'] = $order['phone'];
		$data['address'] = $order['address'];
		$data['email'] = $order['email'];
		$data['description'] = $order['description'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("hu_orders", $data);
		$db->close();
		return $primary_id;
	}
	
	public function addCompanyOrder($order, $company, $agreement_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['company_id'] = $company['id']; 
		$data['company_name'] = $company['name'];
		$data['client_name'] = $company['client_name'];
		$data['position_id'] = $company['position_id'];
		$data['product_type_id'] = $order['product_type_id'];
		$data['payment_status'] = $order['payment_status'];
		$data['pomp_type_id'] = $order['pomp_type_id'];
		$data['size1'] = $order['size1'];
		$data['size2'] = $order['size2'];
		$data['concrete_type_id'] = $order['concrete_type_id'];
		$data['slump_type_id'] = $order['slump_type_id'];
		$data['order_date'] = $order['order_date'];
		$data['order_time'] = $order['order_time'];
		$data['phone'] = $company['phone'];
		$data['address'] = $company['address'];
		$data['email'] = $company['email'];
		$data['description'] = $order['description'];
		$data['agreement_id'] = $agreement_id;
		if($agreement_id != NULL) {
			$data['status'] = 7;
		}
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("hu_orders", $data);
		$db->close();
		return $primary_id;
	}
	
	public function progressFinish($order, $file) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		if(isset($file['quality_cert']['tmp_name']) && file_exists($file['quality_cert']['tmp_name'])) {
			$data['quality_cert'] =  $this->file_attachment($file['quality_cert'], 'quality_cert');	
		}
		if(isset($file['slump_img']['tmp_name']) && file_exists($file['slump_img']['tmp_name'])) {
			$data['slump_img'] =  $this->file_attachment($file['slump_img'], 'slump_img');	
		}
		if(isset($file['research_page']['tmp_name']) &&file_exists($file['research_page']['tmp_name'])) {
			$data['research_page'] =  $this->file_attachment($file['research_page'], 'research_page');	
		}
		if(isset($file['concrete_reply7']['tmp_name']) &&file_exists($file['concrete_reply7']['tmp_name'])) {
			$data['concrete_reply7'] =  $this->file_attachment($file['concrete_reply7'], 'concrete_reply7');	
		}
		if(isset($file['concrete_reply14']['tmp_name']) &&file_exists($file['concrete_reply14']['tmp_name'])) {
			$data['concrete_reply14'] =  $this->file_attachment($file['concrete_reply14'], 'concrete_reply14');	
		}
		if(isset($file['concrete_reply28']['tmp_name']) &&file_exists($file['concrete_reply28']['tmp_name'])) {
			$data['concrete_reply28'] =  $this->file_attachment($file['concrete_reply28'], 'concrete_reply28');	
		}
		$primary_id = $db->query_update("hu_orders", $data, "id='".$order['id']."'");
		$db->close();
		return $primary_id;
	}
	
	public static function changeAgreementId($agreement_id, $id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['agreement_id'] = $agreement_id;
		$primary_id = $db->query_update("hu_orders", $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
	public function agreementSubmit($order, $file) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['title'] = $order['agreement_id'];
		$data['company_id'] = $order['company_id'];
		$data['total_size'] = $order['total_size'];
		$data['unit_price'] = $order['unit_price'];
		$data['total_price'] = $order['total_price'];
		$data['gift'] = $order['gift'];
		$data['barter'] = $order['barter'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		if(file_exists($file['agreement_file']['tmp_name'])) {
			$data['file'] =  $this->file_attachment($file['agreement_file'], 'agreements');	
		}
		$primary_id = $db->query_insert("hu_agreements", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function cancelOrder($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['status'] = 3;
		$primary_id = $db->query_update("hu_orders", $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
	public static function approveOrder($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['status'] = 2;
		$primary_id = $db->query_update("hu_orders", $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
	public function descSubmit($order) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['director_desc'] = $order['director_desc'];
		$primary_id = $db->query_update("hu_orders", $data, "id='".$order['id']."'");
		$db->close();
		return $primary_id;
	}
	
	public function progressUpdate($order) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['produced'] = $order['produced'];
		$data['factory_desc'] = $order['factory_desc'];
		$primary_id = $db->query_update("hu_orders", $data, "id='".$order['id']."'");
		$db->close();
		return $primary_id;
	}
	
	public function produce($order, $id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['concrete_type_id'] = $order;
		$primary_id = $db->query_update("hu_orders", $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
	public function paymentSubmit($order) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['payment1'] = $order['payment1'];
		$data['payment2'] = $order['payment2'];
		$data['barter'] = $order['barter'];
		$data['total_price'] = $order['total_price'];
		$data['price'] = $order['price'];
		$primary_id = $db->query_update("hu_orders", $data, "id='".$order['id']."'");
		$db->close();
		return $primary_id;
	}
	
	public static function fileRemove($file, $folder, $id) {
		if (file_exists(realpath(dirname(__FILE__)).'/../resources/'.$folder.'/'.$file)) {
			unlink(realpath(dirname(__FILE__)).'/../resources/'.$folder.'/'.$file);
			$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
			$db->connect();
			$data[$folder] = NULL;
			$db->query_update("hu_orders", $data, "id='".$id."'");
			$db->close();
			return 1;
		} else {
			return 0;
		}
	}
	
	function file_attachment($file, $folder) {
		$file_extension = pathinfo($file['name']);
		$new_name = rand(100, 999).'_'.date('YmdHis').'.'.$file_extension['extension'];
		move_uploaded_file($file['tmp_name'], realpath(dirname(__FILE__)).'/../resources/'.$folder.'/'.$new_name);
		return $new_name;
	}
	
	public static function checkAgreementId($agreement_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_agreements WHERE title = '".$agreement_id."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public function changeStatus($id, $status) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['status'] = $status;
		$primary_id = $db->query_update("hu_orders", $data, "id='".$id."'");
		$db->close();
		return $primary_id;
	}
	
} 

?>