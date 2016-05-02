<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");

class User {
	
	public static function editUser($user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['id'] = $user['id'];
		$data['username'] = $user['username'];
		if($user['password'] != NULL) {
			$pass = $user['password']; 
			$data['password'] = hash('sha256', $pass.SALT_CHAR);	
		}
		$data['group_id'] = $user['group_id'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_update("hu_users", $data, "id='".$user['id']."'");
		$db->close();
		return $primary_id;
	}
	
	public static function deleteUser($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM hu_users WHERE id='".$id."'";
		$row = $db->query($sql);
		$db->close();
		return $row;
	}
	
	public static function getUser($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_users WHERE id = '".$id."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function userList($from, $limit) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM hu_users WHERE group_id != '1' ORDER BY created DESC LIMIT $from, $limit";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function addUser($user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['username'] = $user['username'];
		$data['password'] = hash('sha256', $user['password'].SALT_CHAR);
		$data['group_id'] = $user['group_id'];
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$primary_id = $db->query_insert("hu_users", $data);
		$db->close();
		return $primary_id;
	}

	public static function allowExecute($group) {
		if(is_array($group)) {
			foreach($group as $grp) :
				if($_SESSION['login']['group_id']==$grp) {
					$return_val = true;
					break;
				}
			endforeach;
			return ($return_val?true:header("Location: index.php"));
		} else {
			return ($_SESSION['login']['group_id']==$group ? true : header("Location: index.php"));
		}
	}

	public static function logout() {
		unset($_SESSION);
		setcookie('login', '', time() - 86400);
		session_destroy();
		session_regenerate_id(true);
		return;
	}
	
	public function login($user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['username'] = $this->clear($user['username']);
		$pass = $this->clear($user['password']);
		$data['password'] = hash('sha256', $pass.SALT_CHAR);
		$sql = "SELECT * FROM hu_users WHERE username = '".$data['username']."' AND password = '".$data['password']."'";
		$login_data = $db->query_first($sql);
		if ($login_data != NULL) {
			session_regenerate_id(true);
			$_SESSION['login'] = array('username' => $data['username'], 'group_id' => $login_data['group_id'], 'id' => $login_data['id']);
			$_SESSION['start'] = time();
			$_SESSION['expire'] = time() + (120*60);
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