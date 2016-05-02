<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/Message.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/District.class.php");


session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'districtList':
		districtList();
		break;
	case 'districtInbox':
		districtInbox();
		break;
	case 'regionInbox':
		regionInbox();
		break;
	case 'adminInbox':
		adminInbox();
		break;
	case 'districtWrite':
		districtWrite();
		break;
	case 'deleteDistrictList':
		deleteDistrictList();
		break;
	case 'deleteAdmin':
		deleteAdmin();
		break;
	case 'deleteRegion':
		deleteRegion();
		break;
	case 'adminList':
		adminList();
		break;
	case 'adminWrite':
		adminWrite();
		break;
	case 'regionList':
		regionList();
		break;
	case 'regionWrite':
		regionWrite();
		break;
}

function regionWrite() {
	User::allowExecute(3);
	$regions = Region::RegionList($_SESSION['login']['district_id']);
	$district = District::getDistrict($_SESSION['login']['district_id']);
	if(isset($_POST['sendMessage'])) {
		$sent_response = Message::sendMessage($_POST);
		if($sent_response == FALSE) {
			header( "Location: message.php?action=regionList&status=error" );
		} else {
			$regions = Region::RegionList($_SESSION['login']['district_id']);
			$district = District::getDistrict($_SESSION['login']['district_id']);
			if(isset($_POST['district'.$district['id']])) {
				Message::sendToDistrict($district['id'], $sent_response);
			}
			foreach($regions as $district_region) :
				if(isset($_POST['region'.$district_region['id']])) {
					Message::sendToRegion($district_region['id'], $sent_response);
				}
			endforeach;
			if (isset($_POST['toAdmin'])) {
				Message::sendToAdmin($_POST['toAdmin'], $sent_response);
			}
			header( "Location: message.php?action=regionList&status=messageSent" );	
		}
	}
	require(ADMIN_TEMPLATE . "message/regionWrite.php");
}

function adminWrite() {
	User::allowExecute(1);
	$districts = District::getDistrictList();
	if(isset($_POST['sendMessage'])) {
		$sent_response = Message::sendMessage($_POST);
		if($sent_response == FALSE) {
			header( "Location: message.php?action=adminList&status=error" );
		} else {
			$districts = District::getDistrictList();
			foreach($districts as $dist) :
				if(isset($_POST['district'.$dist['id']])) {
					Message::sendToDistrict($dist['id'], $sent_response);
				}
				$district_regions = Region::getRegionList($dist['id']);
				foreach($district_regions as $district_region) :
					if(isset($_POST['region'.$district_region['id']])) {
						Message::sendToRegion($district_region['id'], $sent_response);
					}
				endforeach;
			endforeach;
			header( "Location: message.php?action=adminList&status=messageSent" );	
		}
	}
	require(ADMIN_TEMPLATE . "message/adminWrite.php");
}

function adminList() {
	User::allowExecute(1);
	$messages = Message::districtUserSentMessages($_SESSION['login']['id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "messageSent" ) $results['statusMessage'] = "Мессеж илгээгдлээ.";
    	if ( $_GET['status'] == "error" ) $results['statusMessage'] = "Алдаа гарлаа. Дахин оролдоно уу.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Мессеж амжилттай устгагдлаа.";
  	}
	require(ADMIN_TEMPLATE . "message/adminList.php");
}

function adminInbox() {
	User::allowExecute(1);
	$inbox_messages = Message::getAdminInboxMessages();
	require(ADMIN_TEMPLATE . "message/adminInbox.php");
}

function regionList() {
	User::allowExecute(3);
	$messages = Message::districtUserSentMessages($_SESSION['login']['id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "messageSent" ) $results['statusMessage'] = "Мессеж илгээгдлээ.";
    	if ( $_GET['status'] == "error" ) $results['statusMessage'] = "Алдаа гарлаа. Дахин оролдоно уу.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Мессеж амжилттай устгагдлаа.";
  	}
	require(ADMIN_TEMPLATE . "message/regionList.php");
}

function regionInbox() {
	User::allowExecute(3);
	$inbox_messages = Message::getRegionInboxMessages($_SESSION['login']['region_id']);
	require(ADMIN_TEMPLATE . "message/regionInbox.php");
}

function districtInbox() {
	User::allowExecute(2);
	$inbox_messages = Message::getDistrictInboxMessages($_SESSION['login']['district_id']);
	require(ADMIN_TEMPLATE . "message/districtInbox.php");
}

function deleteRegion() {
	User::allowExecute(array(1,2,3));
	$response = Message::deleteMessage((int)$_GET['id']);
	if($response == 0) {
		header( "Location: message.php?action=regionList&status=deleteUnsuccess" );
	} else {
		header( "Location: message.php?action=regionList&status=deleteSuccess" );	
	}
}

function deleteAdmin() {
	User::allowExecute(array(1,2,3));
	$response = Message::deleteMessage((int)$_GET['id']);
	if($response == 0) {
		header( "Location: message.php?action=adminList&status=deleteUnsuccess" );
	} else {
		header( "Location: message.php?action=adminList&status=deleteSuccess" );	
	}
}

function deleteDistrictList() {
	User::allowExecute(2);
	$regionSents = Message::getRegionSentMessages((int)$_GET['id']);
	foreach($regionSents as $regSent) {
		Message::deleteMessageTo($regSent['id']);
	}
	$districtSents = Message::getDistrictSentMessages((int)$_GET['id']);
	foreach($districtSents as $distSent) {
		Message::deleteMessageTo($distSent['id']);
	}
	$adminSent = Message::getAdminSentMessages((int)$_GET['id']);
	Message::deleteMessageTo($adminSent['id']);
	$response = Message::deleteMessage((int)$_GET['id']);
	if($response == 0) {
		header( "Location: message.php?action=districtList&status=deleteUnsuccess" );
	} else {
		header( "Location: message.php?action=districtList&status=deleteSuccess" );	
	}
}

function districtWrite() {
	User::allowExecute(2);
	$regions = Region::RegionList($_SESSION['login']['district_id']);
	$districts = District::getDistrictList();
	if(isset($_POST['sendMessage'])) {
		$regions = Region::RegionList($_SESSION['login']['district_id']);
		$districts = District::getDistrictList();
		$sent_response = Message::sendMessage($_POST);
		if($sent_response == FALSE) {
			header( "Location: message.php?action=districtList&status=error" );
		} else {
			foreach($regions as $region) :
				if (isset($_POST['toRegion'.$region['id']])) {
					Message::sendToRegion($region['id'], $sent_response);
				}
			endforeach;
			foreach($districts as $district) :
				if($district['id'] != $_SESSION['login']['district_id']) :
					if (isset($_POST['toDistrict'.$district['id']])) {
						Message::sendToDistrict($district['id'], $sent_response);
					}
				endif;
			endforeach;
			if (isset($_POST['toAdmin'])) {
				Message::sendToAdmin($_POST['toAdmin'], $sent_response);
			}
			header( "Location: message.php?action=districtList&status=messageSent" );	
		}
	}
	require(ADMIN_TEMPLATE . "message/districtWrite.php");
}

function districtList() {
	User::allowExecute(2);
	$messages = Message::districtUserSentMessages($_SESSION['login']['id']);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "messageSent" ) $results['statusMessage'] = "Мессеж илгээгдлээ.";
    	if ( $_GET['status'] == "error" ) $results['statusMessage'] = "Алдаа гарлаа. Дахин оролдоно уу.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Мессеж амжилттай устгагдлаа.";
  	}
	require(ADMIN_TEMPLATE . "message/districtList.php");
}

function regionDistrict($dist) {
	$district = District::getDistrict($dist);
	return $district['title'];
}

function getUser($id) {
	$user = User::getUserById($id);
	if($user['group_id'] == 1) {
		return 'Системийн админ';
	} elseif($user['group_id'] == 2) {
		$district = District::getDistrict($user['district_id']);
		return $district['title'].' дүүргийн админ';
	} elseif($user['group_id'] == 3) {
		$district = District::getDistrict($user['district_id']);
		$region = Region::getRegion($user['region_id']);
		return $district['title'].' дүүргийн '.$region['title'].'-р хорооны ажилтан';
	}
}


?>