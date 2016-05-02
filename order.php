<?php
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Company.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Order.class.php");
require_once(realpath(dirname(__FILE__))."/classes/ProductType.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Pomp.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Position.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Slump.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Agreement.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Mobile_Detect.php");
require_once(realpath(dirname(__FILE__))."/classes/ConcreteType.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'logout':
		logout();
		break;
	case 'loginOrder':
		loginOrder();
		break;
	case 'directOrder':
		directOrder();
		break;
	case 'companyInfo':
		companyInfo();
		break;
	case 'myOrder':
		myOrder();
		break;
	case 'myOrderInfo':
		myOrderInfo();
		break;
	case 'yearSelect':
		yearSelect();
		break;
	default:
		login();
}

function yearSelect() {
	if (isset($_POST['selectYear'])) {
		header( "Location: order.php?action=myOrder&year=".$_POST['year']."" );
	}
}

function myOrderInfo() {
	if($_SESSION != NULL) {
		$company = Company::getCompany($_SESSION['company']['id']);
		$page_title = $company['name'];
		$order = Order::getOrder($_GET['id']);
		$detect = new Mobile_Detect();
		if($detect->isMobile()) {
			require(SITE_TEMPLATE."order/myOrderInfo.php");
		} else {
			require(WEB_TEMPLATE."order/myOrderInfo.php");
		}
	} else {
		header( "Location: order.php" );
	}
}

function myOrder() {
	if($_SESSION != NULL) {
		$company = Company::getCompany($_SESSION['company']['id']);
		$page_title = $company['name'];
		if(isset($_GET['year'])) {
			$current_year = $_GET['year'];
		} else {
			$current_year = date('Y');
		}
		$orders = Order::getMyOrders($company['id'], $current_year);
		$detect = new Mobile_Detect();
		if($detect->isMobile()) {
			require(SITE_TEMPLATE."order/myOrder.php");
		} else {
			require(WEB_TEMPLATE."order/myOrder.php");
		}
	} else {
		header( "Location: order.php" );
	}
}

function companyInfo() {
	if($_SESSION != NULL) {
		if ( isset( $_GET['status'] ) ) {
    		if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
    		if ( $_GET['status'] == "success" ) $result = "Нууц үг амжилттай солигдлоо.";
    		if ( $_GET['status'] == "notMatch" ) $result = "Нүүц үг баталгаажуулах нууц үгтэй таарсангүй.";
  		}
		$company = Company::getCompany($_SESSION['company']['id']);
		$page_title = $company['name'];
		if(isset($_POST['companySubmit'])) {
			if($_POST['password'] == $_POST['password2']) {
				$response_pass = Company::passChange($_POST);
				if(!$response_pass) {
					header( "Location: order.php?action=companyInfo&status=error" );
				} else {
					header( "Location: order.php?action=companyInfo&status=success" );
				}	
			} else {
				header( "Location: order.php?action=companyInfo&status=notMatch" );
			}
		}
		$detect = new Mobile_Detect();
		if($detect->isMobile()) {
			require(SITE_TEMPLATE."order/companyInfo.php");
		} else {
			require(WEB_TEMPLATE."order/companyInfo.php");
		}
	} else {
		header( "Location: order.php" );
	}
}

function directOrder() {
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
    	if ( $_GET['status'] == "success" ) $result = "Таны захиалга илгээгдлээ.";
  	}
  	$page_title = 'Гэрээт бус захиалга';
  	$parentProTypes = ProductType::getParentList();
  	$pomps = Pomp::getParentList();
	$slumps = Slump::getList();
	$concretes = ConcreteType::getList();
	foreach($parentProTypes as $parentProType) {
		$childProType[$parentProType['id']] = ProductType::getChildList($parentProType['id']);
	}
	$positions = Position::positionList();
	if(isset($_POST['orderSubmit'])) {
		$order = new Order;
		$login = $order->directOrder($_POST);
		if($login == 0) {
			header( "Location: order.php?action=directOrder&status=error" );
		} else {
			header( "Location: order.php?action=directOrder&status=success" );	
		}
	}
	$detect = new Mobile_Detect();
	if($detect->isMobile()) {
		require(SITE_TEMPLATE."order/directOrder.php");
	} else {
		require(WEB_TEMPLATE."order/directOrder.php");
	}
}

function loginOrder() {
	if($_SESSION != NULL) {
		if ( isset( $_GET['status'] ) ) {
    		if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
    		if ( $_GET['status'] == "success" ) $result = "Таны захиалга илгээгдлээ.";
  		}
  		$company = Company::getCompany($_SESSION['company']['id']);
		$parentProTypes = ProductType::getParentList();
		$pomps = Pomp::getParentList();
		$slumps = Slump::getList();
		$concretes = ConcreteType::getList();
		foreach($parentProTypes as $parentProType) {
			$childProType[$parentProType['id']] = ProductType::getChildList($parentProType['id']);
		}
		$page_title = $company['name'];
		if(isset($_POST['orderSubmit'])) {
			$checkAgreement = Agreement::getCompanyAgreementDefault($_SESSION['company']['id']);
			if($checkAgreement != NULL) {
				$order = new Order;
				$login = $order->addCompanyOrder($_POST, $_SESSION['company'], $checkAgreement['id']);
			} else {
				$order = new Order;
				$login = $order->addCompanyOrder($_POST, $_SESSION['company'], NULL);
			}
			if($login == 0) {
				header( "Location: order.php?action=loginOrder&status=error" );
			} else {
				header( "Location: order.php?action=loginOrder&status=success" );	
			}
		}
		$detect = new Mobile_Detect();
		if($detect->isMobile()) {
			require(SITE_TEMPLATE."order/loginOrder.php");
		} else {
			require(WEB_TEMPLATE."order/loginOrder.php");
		}
	} else {
		header( "Location: order.php" );
	}
}

function logout() {
	Company::logout();
	header("Location: order.php?status=logOutSuccess");
}

function login() {
	if (isset($_SESSION['company'])) {
		header( "Location: order.php?action=loginOrder" );
	}
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
    	if ( $_GET['status'] == "success" ) $result = "Таны захиалга илгээгдлээ.";
    	if ( $_GET['status'] == "logOutSuccess" ) $result = "Та системээс гарлаа.";
  	}
	if (isset($_POST['userLogin'])) {
		$company = new Company;
		$login = $company->login($_POST);
		if($login == 0) {
			header( "Location: order.php?status=wrongData" );
		} else {
			header( "Location: order.php?action=loginOrder" );	
		}	
	}
	$detect = new Mobile_Detect();
	if($detect->isMobile()) {
		require(SITE_TEMPLATE."order/login.php");
	} else {
		require(WEB_TEMPLATE."order/login.php");	
	}
}

function getPaymentStatusName($payment) {
	if($payment == 1) {
		$payment_status = 'Бэлнээр';
	} else {
		$payment_status = 'Гэрээний дагуу';
	}
	return $payment_status;
}

function getPositionName($positionid) {
	$position = Position::getPosition($positionid);
	return $position['title'];
}

function getProductTypeName($productTypeId) {
	$product_type = ProductType::getProductType($productTypeId);
	return $product_type['title'];
}

function getSlumpTypeName($slumpTypeId) {
	$slumpType = Slump::getSlump($slumpTypeId);
	return $slumpType['title'];
}

function getPompName($pompId) {
	$pomp = Pomp::getPomp($pompId);
	return $pomp['title'];
}

function getStatusColor($stat) {
	switch ( $stat ) {
	case 0:
		$color = '#FFFFFF';
		break;
	case 1:
		$color  = '#fdc629';
		break;
	case 2:
		$color  = '#008cba';
		break;
	case 3:
		$color  = '#f04124';
		break;
	case 4:
		$color = '#ff7800';
		break;
	case 5:
		$color = '#464bf6';
		break;
	case 6:
		$color = '#077000';
		break;
	}
	return $color;
}

function getConcreteTypeName($concreteTypeId) {
	$concreteType = ConcreteType::getConcreteType($concreteTypeId);
	return $concreteType['title'];
}

?>