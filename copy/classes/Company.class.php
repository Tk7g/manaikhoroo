<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class Company {
	
	public static function getList() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_company_info ORDER BY agreement_id";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getCompany($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_company_info WHERE id = '".$id."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function deleteCompany($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM hu_company_info WHERE id='".$id."'";
		$row = $db->query($sql);
		$db->close();
		return $row;
	}
	
	public static function editCompany($company) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['id'] = $company['id'];
		$data['agreement_id'] = $company['agreement_id'];
		if($company['password'] != NULL) {
			$pass = $company['password']; 
			$data['password'] = hash('sha256', $pass.SALT_CHAR);	
		}
		$data['name'] = $company['name'];
		$data['client_name'] = $company['client_name'];
		$data['position_id'] = $company['position_id'];
		$data['phone'] = $company['phone'];
		$data['address'] = $company['address'];
		$data['email'] = $company['email'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_update("hu_company_info", $data, "id='".$company['id']."'");
		$db->close();
		return $primary_id;
	}
	
	public static function addCompany($company) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['agreement_id'] = $company['agreement_id'];
		$data['password'] = hash('sha256', $company['password'].SALT_CHAR);
		$data['name'] = $company['name'];
		$data['client_name'] = $company['client_name'];
		$data['position_id'] = $company['position_id'];
		$data['phone'] = $company['phone'];
		$data['address'] = $company['address'];
		$data['email'] = $company['email'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("hu_company_info", $data);
		$db->close();
		return $primary_id;
	}
	
	public static function companyList($from, $limit) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_company_info ORDER BY created DESC LIMIT $from, $limit";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function passChange($info) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$pass = self::clear($info['password']);
		$data['password'] = hash('sha256', $pass.SALT_CHAR);
		$primary_id = $db->query_update("hu_company_info", $data, "id='".$info['id']."'");	
		$db->close();
		return $primary_id;
	}

	public static function logout() {
		unset($_SESSION);
		setcookie('company', '', time() - 86400);
		session_destroy();
		session_regenerate_id(true);
		return;
	}
	
	public function login($user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['agreement_id'] = $user['agreement_id'];
		$pass = $this->clear($user['password']);
		$data['password'] = hash('sha256', $pass.SALT_CHAR);
		$sql = "SELECT * FROM hu_company_info WHERE agreement_id = '".$data['agreement_id']."' AND password = '".$data['password']."'";
		$login_data = $db->query_first($sql);
		if ($login_data != NULL) {
			session_regenerate_id(true);
			$_SESSION['company'] = array('agreement_id' => $data['agreement_id'], 'name' => $login_data['name'], 'id' => $login_data['id'], 'client_name' => $login_data['client_name'], 'position_id' => $login_data['position_id'], 'phone' => $login_data['phone'], 'address' => $login_data['address'], 'email' => $login_data['email']);
			$_SESSION['company_start'] = time();
			$_SESSION['company_expire'] = time() + (120*60);
			$msg = 1;
		} else {
			$msg = 0;
		}
		$db->close();
		return $msg;
	}
	
	function clear($message) {
		if(!get_magic_quotes_gpc()) {
			$message = addslashes($message);
		}
		$message = strip_tags($message);
		$message = htmlentities($message);
		return trim($message);
	}
	
} 

?>