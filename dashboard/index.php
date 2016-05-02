<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Year.class.php");
require_once(realpath(dirname(__FILE__))."/../config/mailer/PHPMailerAutoload.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'home' :
		home();
		break;
	case 'logout':
		logout();
		break;
	case 'forgot':
		forgot();
		break;
	default:
		login();
}

function forgot() {
	if (isset($_SESSION['login'])) {
		header( "Location: index.php?action=home" );
	}
	if (isset($_POST['userForgot'])) {
		$user = new User;
		$login = $user->forgotPassword($_POST);
		if($login == 0) {
			header( "Location: index.php?status=mailNotExist" );
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
    		header( "Location: index.php?status=mailNotExist" );
		} else {
    		header( "Location: index.php?status=forgotMailSent" );	
		}
			
		}
	}
	require(ADMIN_TEMPLATE . "forgot.php");
}

function login() {
	if (isset($_SESSION['login'])) {
		header( "Location: index.php?action=home" );
	}
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "wrongData" ) $result = "Таны оруулсан мэдээлэл буруу байна.";
    	if ( $_GET['status'] == "logOutSuccess" ) $result = "Системээс гарлаа.";
    	if ( $_GET['status'] == "forgotMailSent" ) $result = "Шинэ нууц үг таны и-мэйл хаяг руу илгээгдлээ.";
    	if ( $_GET['status'] == "mailNotExist" ) $result = "Таны оруулсан и-мэйл хаяг олдсонгүй.";
  	}
	if (isset($_POST['userLogin'])) {
		$user = new User;
		$login = $user->login($_POST);
		if($login == 0) {
			header( "Location: index.php?status=wrongData" );
		} else {
			header( "Location: index.php?action=home" );	
		}	
	}
	require(ADMIN_TEMPLATE . "login.php");
}

function logout() {
	User::logout();
	header("Location: index.php?status=logOutSuccess");
}

function home() {
if($_SESSION != NULL) {
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "passUn" ) $result = "Нууц үг солих явцад алдаа гарлаа дахин оролдоно уу.";
    	if ( $_GET['status'] == "passSuccess" ) $result = "Таны нууц үг амжилттай солигдлоо.";
  	}
	if($_SESSION['login']['group_id'] == 1) {
		$info = new Info;
		$results = $info->getCityInfo();
		$latest_infos = $info->latestInfo(20);
		$marker = new Marker;
		$latest_markers = $marker->latestMarkers(10);
		require( ADMIN_TEMPLATE . "cityInfo.php" );	
	} elseif($_SESSION['login']['group_id'] == 2) {
		$results = Info::getDistrictInfo($_SESSION['login']['district_id']);
		$info = new Info;
		$latest_infos = $info->latestDistrictInfo(20, $_SESSION['login']['district_id']);
		$marker = new Marker;
		$latest_markers = $marker->latestDistrictMarkers(10, $_SESSION['login']['district_id']);
		require( ADMIN_TEMPLATE . "districtInfo.php" );	
	} elseif($_SESSION['login']['group_id'] == 3) {
		header(false);
		$results = Info::getRegionInfo($_SESSION['login']['district_id'], $_SESSION['login']['region_id']);
		$sections = Section::getSectionList($_SESSION['login']['region_id']);
		$current_year = Year::getDefaultYear();
		foreach($sections as $sec) {
			$sectionInfos[$sec['id']] = Info::SectionInfo($_SESSION['login']['region_id'], $_SESSION['login']['district_id'], $sec['title'], $current_year['year']);
		}
		require( ADMIN_TEMPLATE . "regionInfo.php" );
	} else {
		header("Location: /index.php");
	}
} else {
	header( "Location: index.php" );
}
}

?>