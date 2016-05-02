<?php
error_reporting(0);
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Faq.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Sanal.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Link.class.php");
require_once(realpath(dirname(__FILE__))."/classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/config/mailer/PHPMailerAutoload.php");
@include_once( '/home2/manaikho/public_html/stat/stats-include.php' );

session_start();

$action = isset( $_GET['page'] ) ? $_GET['page'] : "";

switch ( $action ) {
	case 'write':
		sanalAdd();
		break;
	case 'register':
		register();
		break;
	case 'forgot':
		forgot();
		break;
	case 'home' :
		home();
		break;
	case 'sentlist':
		sentList();
		break;
	case 'viewReply':
		viewReply();
		break;
	case 'logout':
		logout();
		break;
	case 'addMarker':
		addMarker();
		break;
	case 'select':
		select();
		break;
	case 'regionBorder':
		regionBorder();
		break;
	case 'myMarker':
		myMarker();
		break;
	case 'delMyMarker':
		delMyMarker();
		break;
	case 'passChange':
		passChange();
		break;
	case 'viewMarker':
		viewMarker();
		break;
	default:
		login();
}

function passChange() {
	User::allowExecute(4);
	if (isset($_POST['passChange'])) {
		$user = new User;
		$user_id = $user->passwordChange($_SESSION['login']['username'], $_POST);
		if($user_id == 0) {
			header( "Location: user.php?page=write&status=passUnsuccess" );
		} else {
			header( "Location: user.php?page=write&status=passSuccess" );	
		}
	}
	require(SITE_TEMPLATE . "users/passChange.php");
}

function myMarker() {
	User::allowExecute(4);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "deleteUnsuccess" ) $result = "Устгах явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $result = "Амжилттай устгагдлаа.";
  	}
	$user = User::getUser($_SESSION['login']['username']);
	$markers = Marker::myMarkers($user['id']);
	require(SITE_TEMPLATE . "users/myMarkers.php");
}

function delMyMarker() {
	User::allowExecute(4);
	$user = User::getUser($_SESSION['login']['username']);
	$user_id = Marker::deleteMyMarker($_GET['id'], $user['id']);
	if($user_id == 0) {
		header( "Location: user.php?page=myMarker&status=deleteUnsuccess" );
	} else {
		header( "Location: user.php?page=myMarker&status=deleteSuccess" );	
	}
}

function viewMarker() {
	User::allowExecute(4);
	$user = User::getUser($_SESSION['login']['username']);
	$results = Marker::nonPublishedRegionMarker($_GET['type'], $_GET['r'], $_GET['id']);
	if($results == NULL) {
		$msg = 'Таны зурган тэмдэглэгээ нийтлэгдсэн байна.';
	} else {
		$msg = 'Зурган тэмдэглэгээг одоогийн байдлаар нийтлээгүй байна.';
	}
	$region = Region::getRegion($_GET['r']);
	$district = District::getDistrict($_GET['d']);
	$type = Marker::getType($_GET['type']);
	require(SITE_TEMPLATE . "users/viewMarker.php");
} 

function addMarker() {
	User::allowExecute(4);
	if(!isset($_GET['r']) || !isset($_GET['d']) || !isset($_GET['type'])) {
		header( "Location: user.php?page=select" );
	}
	$region = Region::getRegion($_GET['r']);
	$district = District::getDistrict($_GET['d']);
	$type = Marker::getType($_GET['type']);
	require(SITE_TEMPLATE . "users/addMarker.php");
}

function regionBorder() {
		User::allowExecute(4);
		$results = Marker::getRegionborder($_GET['region']);
		$data['coordinate'] = array();
		$k = 0;
		foreach($results as $result) {
			$data['coordinate'][$k] = explode(',', $result['coordinate'], 2);
			$k = $k + 1;
		}
		header('Content-type: application/json');
		echo json_encode($data);
}

function select() {
	User::allowExecute(4);
	if (isset($_POST['selectType'])) {
		if(!empty($_POST['district_id']) && !empty($_POST['region_id']) && !empty($_POST['type_id'])) {
			header( "Location: user.php?page=addMarker&type=".$_POST['type_id']."&d=".$_POST['district_id']."&r=".$_POST['region_id'] );
		} else {
			header( "Location: user.php?page=select" );
		}
	}
	$types = Marker::getTypes();
	$districts = District::getDistrictList();
	require(SITE_TEMPLATE . "users/select.php");
}

function viewReply() {
	User::allowExecute(4);
	$user = User::getUserByEmail($_SESSION['login']['email']);
	$myLoginData = file_get_contents('http://http://ub1200.mn/mobilelog/'.$_GET['id']);
	$reply=simplexml_load_string($myLoginData);
	require(SITE_TEMPLATE . "users/viewReply.php");
}

function sentList() {
if($_SESSION != NULL) {
	$user_info = User::getUserByEmail($_SESSION['login']['email']);
	$myLoginData = file_get_contents('http://ub1200.mn/mobilelist/'.$user_info['ub_id']);
	$xml_data=simplexml_load_string($myLoginData);
	require(SITE_TEMPLATE . "users/myList.php");
} else {
	header( "Location: user.php" );
}
}

function sanalAdd() {
if($_SESSION != NULL) {
	$myLoginData = file_get_contents('http://ub1200.mn/mobilecategory');
	$xml=simplexml_load_string($myLoginData);
	$types = $xml;
	$districts = Sanal::getDistricts();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "error" ) $result = "Мэдээлэл илгээхэд алдаа гарлаа.";
    	if ( $_GET['status'] == "sent" ) $result = "Мэдээлэл амжилттай илгээгдлээ.";
    	if ( $_GET['status'] == "passUnsuccess" ) $result = "Нууц үг солих явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "passSuccess" ) $result = "Нууц үг амжилттай солигдлоо.";
  	}
	if (isset($_POST['sendSanal'])) {
		//$sanal = new Sanal;
		//$user_id = User::getUser($_SESSION['login']['username']);
		//$send = $sanal->sanalAdd($_POST, $_FILES, $user_id['id']);
   		foreach($_POST as $k => $v) { 
      		$postData .= $k . '='.$v.'&'; 
   		}
   		$postData .= 'pic='.$_FILES['files'].'&';
   		rtrim($postData, '&');
 
    	$ch = curl_init();  
 
    	curl_setopt($ch,CURLOPT_URL,"http://ub1200.mn/mobilesave");
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,CURLOPT_HEADER, false); 
	    curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
	    $output=curl_exec($ch);
 
	    curl_close($ch);
	    
	    $sanal_success = $output->CODE;
	    
		if($sanal_success == 2) {
			header( "Location: user.php?page=write&status=error" );
		} elseif($sanal_success == 0) {
			header( "Location: user.php?page=write&status=sent" );
		}	
	}
	require(SITE_TEMPLATE . "users/sanalAdd.php");
} else {
	header( "Location: user.php" );
}
}

function forgot() {
	if (isset($_SESSION['login'])) {
		header( "Location: user.php?page=home" );
	}
	if (isset($_POST['userForgot'])) {
		$user = new User;
		$login = $user->forgotUserPass($_POST);
		if($login == 0) {
			header( "Location: user.php?status=mailNotExist" );
		} else {
			
		$myLoginData = file_get_contents('http://ub1200.mn/mobileforgot/'.$_POST['email']);
		$xml=simplexml_load_string($myLoginData);
		$success_ub = $xml->CODE;
		if ($success_ub == 1) {
    		header( "Location: user.php?status=mailNotExist" );
		} elseif($success_ub == 0) {
    		header( "Location: user.php?status=forgotMailSent" );	
		} elseif($success_ub == 2) {
			header( "Location: user.php?status=systemError" );
		}
			
		}
	}
	$faq = Faq::getFaq(1);
	require(SITE_TEMPLATE . "users/forgot.php");
}

function register() {
	if (isset($_SESSION['login'])) {
		header( "Location: user.php?page=home" );
	}
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "wrongData" ) $result = "Таны оруулсан мэдээлэл буруу байна.";
    	if ( $_GET['status'] == "mailSent" ) $result = "Таны и-мэйл хаяг руу системд нэвтрэхэд шаардлагатай мэдээллийг илгээлээ.";
  	}
	if (isset($_POST['userRegister'])) {
		$myRegisterData = file_get_contents('http://ub1200.mn/mobileregister/'.$_POST['email'].'/'.$_POST['phone'].'');
		$xml=simplexml_load_string($myRegisterData);
		
		$ub_success = $xml->CODE;
		$ub_id = $xml->ID;
		
		if($ub_success == 0) {
		
			$user = new User;
			$login = $user->registerUser($_POST, $ub_id);
			if($login == 0) {
				header( "Location: user.php?status=systemError" );
			} else {
				$profile_xml = simplexml_load_string($myProfileData);
				$success_code = $profile_xml->CODE;
				if($success_code == 0) {
					header( "Location: user.php?status=mailSent" );		
				} else {
					header( "Location: user.php?status=infoError" );
				}
			}
			
		} elseif($ub_success == 1) {
			header( "Location: user.php?status=mailExist" );	
		} elseif($ub_success == 2) {
			header( "Location: user.php?status=systemError" );
		}
	}
	$faq = Faq::getFaq(1);
	require(SITE_TEMPLATE . "users/register.php");
}

function login() {
	if (isset($_SESSION['login'])) {
		header( "Location: user.php?page=home" );
	}
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "wrongData" ) $result = "Таны оруулсан мэдээлэл буруу байна.";
    	if ( $_GET['status'] == "logOutSuccess" ) $result = "Системээс гарлаа.";
    	if ( $_GET['status'] == "mailSent" ) $result = "Амжилттай бүртгүүллээ. Та бүртгүүлэх үед оруулсан мэйл хаягаа шалгана уу.";
    	if ( $_GET['status'] == "forgotMailSent" ) $result = "Таны и-мэйл хаяг руу хэрэглэгчийн нэр, нууц үгийг илгээлээ. Та и-мэйл хаягаа шалгана уу.";
    	if ( $_GET['status'] == "mailNotExist" ) $result = "Таны оруулсан и-мэйл хаяг буруу байна.";
    	if ( $_GET['status'] == "mailExist" ) $result = "Энэ и-мэйл хаяг бүртгэгдсэн байна.";
    	if ( $_GET['status'] == "systemError" ) $result = " Уучлаарай системд алдаа гарлаа. Та дахин хандана уу.";
    	if ( $_GET['status'] == "infoError" ) $result = " Уучлаарай таны оруулсан мэдээлэл буруу байна.";
  	}
	if (isset($_POST['userLogin'])) {
		$myLoginData = file_get_contents('http://ub1200.mn/mobilelogin/'.$_POST['email'].'/'.$_POST['password']);
		$xml=simplexml_load_string($myLoginData);
		$ub_id = $xml->ID;
		if($ub_id == 0) {
			header( "Location: user.php?status=wrongData" );
		} else {
			$user = new User;
			$login = $user->userLogin($_POST, $ub_id);
			if($login == 0) {
				$create = $user->ubUserCreate($_POST, $ub_id);
				if($create == 0) {
					header( "Location: user.php?status=wrongData" );	
				} else {
					$login = $user->userLogin($_POST, $ub_id);
					if($login['ub_first'] == 0) {
					$user->editUbFirst($login['id'], $ub_id);	
					}
					if($success_code == 0) {
						header( "Location: user.php?page=home");	
					} else {
						header( "Location: user.php?status=wrongData" );
					}	
				}
			} else {
				$register = urlencode($login['identity']);
				$lastname = urlencode($login['lastname']);
				$firstname = urlencode($login['firstname']);
				$mypData = file_get_contents('http://ub1200.mn/mobileprofile/136217/'.$lastname.'/'.$firstname.'/'.$register.'/99057451/402/manaikhoroo');
				$xml1=simplexml_load_string($mypData);
				$success_code = $xml1->CODE;
				if($login['ub_first'] == 0) {
					$user->editUbFirst($login['id'], $ub_id);	
				}
				if($success_code == 0) {
					header( "Location: user.php?page=home");	
				} else {
					header( "Location: user.php?status=wrongData" );
				}
			}	
		}	
	}
	$faq = Faq::getFaq(1);
	require(SITE_TEMPLATE . "users/login.php");
}

function logout() {
	User::logout();
	header("Location: user.php?status=logOutSuccess");
}

function home() {
if($_SESSION != NULL) {
	if($_SESSION['login']['group_id'] == 4) {
		$faq = Faq::getFaq(2);
		require(SITE_TEMPLATE . "users/home.php");
	} else {
		header("Location: dashboard/index.php");
	}
} else {
	header( "Location: index.php" );
}
}

?>