<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");
define('TABLE_USERS', "kh_users");
define('TABLE_GROUPS', "kh_groups");
define('TABLE_REGIONS', "kh_regions");
define('TABLE_DISTRICTS', "kh_districts");

class User {
	
	public static function getUserByEmail($email) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_USERS." WHERE email LIKE '".$email."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function getUserById($userid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_USERS." WHERE id LIKE '".$userid."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
	public static function getUser($username) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_USERS." WHERE username LIKE '".$username."'";
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}

	function mailPassword($mail, $username, $password) {
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'mail.manaikhoroo.ub.gov.mn';
		$mail->SMTPAuth = true;
		$mail->Username = 'contact@manaikhoroo.ub.gov.mn';
		$mail->Password = 'Pass2015';
		$mail->SMTPSecure = 'tls';   
		$mail->Port = 25;

		$mail->setFrom('contact@manaikhoroo.ub.gov.mn');
		$mail->addReplyTo('contact@manaikhoroo.ub.gov.mn');
		$mail->addAddress($mail);
		$mail->Subject = 'Манайхороо газрын зураглалын сан';
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);  
		$mail->Body = "Та манай <a href='http://manaikhoroo.ub.gov.mn'>manaikhoroo.ub.gov.mn</a> системд амжилттай бүртгүүллээ.<br/>Таны хэрэглэгчийн нэр: ".$username."<br/>Таны нууц үг: ".$password;
		
		if (!$mail->send()) {
    		return 0;
		} else {
    		return 1;
		}
		
	}
	
	public function passwordChange($user, $password) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_USERS." WHERE username='".$user."'";
		$user_data = $db->query_first($sql);
		if ($user_data != NULL) {
			$data['password'] = hash('sha256', $password['password'].SALT_CHAR);
			$db->query_update(TABLE_USERS, $data, "id='".$user_data['id']."'");
			$exist_user = 1;
		} else {
			$exist_user = 0;
		}
		$db->close();
		return $exist_user;
	}
	
	function mailForgotPassword($mail, $username, $password) {
		$email_message = "Таны <a href='http://manaikhoroo.ub.gov.mn'>manaikhoroo.ub.gov.mn</a> системд нэвтрэх нууц үг амжилттай солигдлоо.<br/>Таны хэрэглэгчийн нэр: ".$username."<br/>Таны нууц үг: ".$password;
		$email_subject = "Манай хороо цахим систем";
		$email_to = $mail;
		$headers = "From:contact@manaikhoroo.ub.gov.mn";
		@mail($email_to, $email_subject, $email_message, $headers);  
	}
	
	public function forgotUserPass($user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['email'] = $this->clear($user['email']);
		$sql = "SELECT * FROM kh_users WHERE email = '".$data['email']."'";
		$user_data = $db->query_first($sql);
		if($user_data != NULL) {
			$msg = 1;
		} else {
			$msg = 0;
		}
		$db->close();
		return $msg;
	}
	
	public function forgotPassword($user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['email'] = $this->clear($user['email']);
		$sql = "SELECT * FROM kh_users WHERE email = '".$data['email']."'";
		$user_data = $db->query_first($sql);
		if($user_data != NULL) {
			$pass = rand(1000, 100000); 
			$data['password'] = hash('sha256', $pass.SALT_CHAR);
			$db->query_update(TABLE_USERS, $data, "id='".$user_data['id']."'");
			$msg = array('email' => $user_data['email'], 'password' => $pass, 'username' => $user_data['username']);
		} else {
			$msg = 0;
		}
		$db->close();
		return $msg;
	}

	public function registerUser($user, $ub_id) {
			$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
			$db->connect();
			$data['username'] = $this->clear($user['username']);
			$data['group_id'] = 4;
			$data['email'] = $user['email'];
			$data['identity'] = $this->clear($user['identity']);
			$data['firstname'] = $this->clear($user['firstname']);
			$data['lastname'] = $this->clear($user['lastname']);
			$data['phone'] = $this->clear($user['phone']);
			$data['ub_id'] = $ub_id;
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$sql = "SELECT * FROM ".TABLE_USERS." WHERE username='".$data['username']."' AND email='".$data['email']."'";
			$user_data = $db->query_first($sql);
			if ($user_data == NULL) {
				$db->query_insert(TABLE_USERS, $data);
				$primary_id = 1;
			} else {
				$primary_id = 0;
			}
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
	
	public function ubUserCreate($user, $ub_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
			$db->connect();
			$data['username'] = 'ub1200';
			$data['group_id'] = 4;
			$data['email'] = $user['email'];
			$data['identity'] = 'ub1200';
			$data['firstname'] = 'ub1200';
			$data['lastname'] = 'ub1200';
			$data['phone'] = 'ub1200';
			$data['ub_id'] = $ub_id;
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$sql = "SELECT * FROM ".TABLE_USERS." WHERE email='".$data['email']."'";
			$user_data = $db->query_first($sql);
			if ($user_data == NULL) {
				$db->query_insert(TABLE_USERS, $data);
				$primary_id = 1;
			} else {
				$primary_id = 0;
			}
			$db->close();
			return $primary_id;
	}
	
	public function userLogin($user, $ub_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['email'] = $this->clear($user['email']);
		$password['password'] = $user['password'];
		$sql = "SELECT * FROM ".TABLE_USERS." WHERE email = '".$data['email']."'";
		$login_data = $db->query_first($sql);
		if ($login_data != NULL) {
			$db->query_update(TABLE_USERS, $password, "id='".$login_data['id']."'");
			session_regenerate_id(true);
			$_SESSION['login'] = array('username' => $login_data['username'], 'group_id' => $login_data['group_id'], 'district_id' => $login_data['district_id'], 'region_id' => $login_data['region_id'], 'email' => $login_data['email'], 'identity' => $login_data['identity'], 'firstname' => $login_data['firstname'], 'lastname' => $login_data['lastname'], 'ub_id' => $login_data['ub_id']);
			$_SESSION['start'] = time();
			$_SESSION['expire'] = time() + (120*60);
			$msg = $login_data;
		} else {
			$msg = 0;
		}
		$db->close();
		return $msg;
	}
	
	public function editUbFirst($user, $ub_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['ub_first'] = 1;
		$data['ub_id'] = $ub_id;
		$db->query_update(TABLE_USERS, $data, "id='".$user."'");
		$db->close();
	}
	
	public function login($user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['username'] = $this->clear($user['username']);
		$pass = $this->clear($user['password']);
		$data['password'] = hash('sha256', $pass.SALT_CHAR);
		$sql = "SELECT * FROM ".TABLE_USERS." WHERE username = '".$data['username']."' AND password = '".$data['password']."'";
		$login_data = $db->query_first($sql);
		if ($login_data != NULL) {
			session_regenerate_id(true);
			$_SESSION['login'] = array('id' => $login_data['id'], 'username' => $data['username'], 'group_id' => $login_data['group_id'], 'password' => $login_data['password'], 'district_id' => $login_data['district_id'], 'region_id' => $login_data['region_id'], 'email' => $login_data['email'], 'identity' => $login_data['identity'], 'firstname' => $login_data['firstname'], 'lastname' => $login_data['lastname']);
			$_SESSION['start'] = time();
			$_SESSION['expire'] = time() + (120*60);
			$msg = 1;			
		} else {
			$msg = 0;
		}
		$db->close();
		return $msg;
	}
	
	public function addUser($user) {
			$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
			$db->connect();
			$data['username'] = $this->clear($user['username']); 
			$pass = $user['password']; 
			$data['password'] = hash('sha256', $pass.SALT_CHAR);
			$data['group_id'] = $user['group_id'];
			if(isset($user['district_id'])) {
				$data['district_id'] = $user['district_id'];
			}
			if(isset($user['region_id'])) { 
				$data['region_id'] = $user['region_id'];
			}
			$data['email'] = $user['email'];
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$sql = "SELECT * FROM ".TABLE_USERS." WHERE username='".$data['username']."'";
			$user_data = $db->query_first($sql);
			if ($user_data == NULL) {
				$primary_id = $db->query_insert(TABLE_USERS, $data);
			} else {
				$primary_id = 0;
			}
			$db->close();
			return $primary_id;
	}
	
	function clear($message) {
		if(!get_magic_quotes_gpc()) {
			$message = addslashes($message);
		}
		$message = strip_tags($message);
		$message = htmlentities($message);
		return trim($message);
	}
	
	public static function editUser($user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['username'] = $user['username']; 
		if($user['password'] != NULL) {
			$pass = $user['password']; 
			$data['password'] = hash('sha256', $pass.SALT_CHAR);	
		}
		$data['group_id'] = $user['group_id'];
		if(isset($data['district_id'])) {
			$data['district_id'] = $user['district_id'];
		}
		if(isset($data['region_id'])) { 
			$data['region_id'] = $user['region_id'];
		}
		$data['email'] = $user['email'];
		$data['modified'] = date('Y-m-d H:i:s');
		$sql = "SELECT * FROM ".TABLE_USERS." WHERE username='".$data['username']."' AND id <> '".$user['id']."'";
		$user_data = $db->query_first($sql);
		if ($user_data == NULL) {
			$db->query_update(TABLE_USERS, $data, "id='".$user['id']."'");
			$exist_user = 1;
		} else {
			$exist_user = 0;
		}
		$db->close();
		return $exist_user;
	}
	
	public static function deleteUser($userid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM ".TABLE_USERS." WHERE id='".$userid."'";
		$user = $db->query($sql);
		$db->close();
		return $user;
	}
	
	public static function getUserListDistrict($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
			$sql = "SELECT kh_users.id, kh_users.username, kh_users.group_id, kh_districts.title as district, kh_regions.title as region, kh_users.created FROM ".TABLE_USERS." 
					LEFT JOIN ".TABLE_REGIONS." ON kh_users.region_id=kh_regions.id 
					LEFT JOIN ".TABLE_DISTRICTS." ON kh_users.district_id=kh_districts.id
					WHERE kh_users.district_id = ".$district." AND kh_users.group_id = 3
					ORDER BY kh_users.created DESC";
			$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getUserList() {
    	$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
			$sql = "SELECT kh_users.id, kh_users.username, kh_users.group_id, kh_districts.title as district, kh_regions.title as region, kh_users.created FROM ".TABLE_USERS." 
					LEFT JOIN ".TABLE_REGIONS." ON kh_users.region_id=kh_regions.id 
					LEFT JOIN ".TABLE_DISTRICTS." ON kh_users.district_id=kh_districts.id
					ORDER BY kh_users.created DESC";
			$rows = $db->fetch_all_array($sql);
		$db->close();
		
		return $rows;
  	}
	
	public static function getUserInfo($userid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_USERS." WHERE id=".$userid;
		$row = $db->query_first($sql);
		$db->close();
		return $row;
	}
	
} 

?>