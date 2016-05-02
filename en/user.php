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
	$user = User::getUser($_SESSION['login']['username']);
	$sanal = Sanal::getInfo($_GET['id']);
	if($sanal['user_id'] != $user['id']) {
		header("Location: user.php?page=sentlist");
	}
	$reply = Sanal::getReply($sanal['id']);
	if($reply['seen'] == 0) {
		$seen = Sanal::replySeen($reply['id']);	
	}
	require(SITE_TEMPLATE . "users/viewReply.php");
}

function sentList() {
if($_SESSION != NULL) {
	$user_id = User::getUser($_SESSION['login']['username']);
	$results = Sanal::myList($user_id['id']);
	require(SITE_TEMPLATE . "users/myList.php");
} else {
	header( "Location: user.php" );
}
}

function sanalAdd() {
if($_SESSION != NULL) {
	$types = Sanal::getType();
	$districts = Sanal::getDistricts();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "error" ) $result = "Мэдээлэл илгээхэд алдаа гарлаа.";
    	if ( $_GET['status'] == "sent" ) $result = "Мэдээлэл амжилттай илгээгдлээ.";
    	if ( $_GET['status'] == "passUnsuccess" ) $result = "Нууц үг солих явцад алдаа гарлаа.";
    	if ( $_GET['status'] == "passSuccess" ) $result = "Нууц үг амжилттай солигдлоо.";
  	}
	if (isset($_POST['sendSanal'])) {
		$sanal = new Sanal;
		$user_id = User::getUser($_SESSION['login']['username']);
		$send = $sanal->sanalAdd($_POST, $_FILES, $user_id['id']);
		if($send == false) {
			header( "Location: user.php?page=write&status=error" );
		} else {
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
		$login = $user->forgotPassword($_POST);
		if($login == 0) {
			header( "Location: user.php?status=mailNotExist" );
		} else {
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
		$mail->addAddress($login['email']);
		$mail->Subject = 'Манайхороо газрын зураглалын сан';
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		$mail->Body = "Таны <a href='http://manaikhoroo.ub.gov.mn'>manaikhoroo.ub.gov.mn</a> системд нэвтрэх нууц үг амжилттай солигдлоо.<br/>Таны хэрэглэгчийн нэр: ".$login['username']."<br/>Таны нууц үг: ".$login['password'];
		if (!$mail->send()) {
    		header( "Location: user.php?status=mailNotExist" );
		} else {
    		header( "Location: user.php?status=forgotMailSent" );	
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
		$user = new User;
		$login = $user->registerUser($_POST);
		if($login == 0) {
			header( "Location: user.php?status=mailNotExist" );
		} else {
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
		$mail->addAddress($login['email']);
		$mail->Subject = 'Манайхороо газрын зураглалын сан';
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true); 
		$mail->Body = "Та манай <a href='http://manaikhoroo.ub.gov.mn'>manaikhoroo.ub.gov.mn</a> системд амжилттай бүртгүүллээ.<br/>Таны хэрэглэгчийн нэр: ".$login['username']."<br/>Таны нууц үг: ".$login['password'];
		if (!$mail->send()) {
    		header( "Location: user.php?status=mailNotExist" );
		} else {
    		header( "Location: user.php?status=mailSent" );	
		}
			
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
  	}
	if (isset($_POST['userLogin'])) {
		$user = new User;
		$login = $user->login($_POST);
		if($login == 0) {
			header( "Location: user.php?status=wrongData" );
		} else {
			header( "Location: user.php?page=home" );	
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