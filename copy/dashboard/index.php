<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Order.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Mobile_Detect.php");
require_once(realpath(dirname(__FILE__))."/../classes/ProductType.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'home' :
		home();
		break;
	case 'logout':
		logout();
		break;
	default:
		login();
}

function login() {
	$detect = new Mobile_Detect();
	if (isset($_SESSION['login'])) {
		header( "Location: index.php?action=home" );
	}
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "wrongData" ) $result = "Таны оруулсан мэдээлэл буруу байна.";
    	if ( $_GET['status'] == "logOutSuccess" ) $result = "Системээс гарлаа.";
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
	if($detect->isMobile()) {
		require(ADMIN_TEMPLATE . "login.php");	
	} else {
		require(ADMIN_WEB_TEMPLATE . "login.php");
	}
}

function logout() {
	User::logout();
	header("Location: index.php?status=logOutSuccess");
}

function home() {
if($_SESSION != NULL) {
	$detect = new Mobile_Detect();
	$page_title = 'Удирдлагын хэсэг';
	if($_SESSION['login']['group_id'] == 1) {
		$new_companyOrders = Order::getCompanyOrderStatusAll(0, date('Y'));
		$agreement_companyOrders = Order::getCompanyOrderStatusAll(1, date('Y'));
		$accepted_companyOrders = Order::getCompanyOrderStatusAll(2, date('Y'));
		$toFactory_companyOrders = Order::getCompanyOrderStatusAll(4, date('Y'));
		$producing_companyOrders = Order::getCompanyOrderStatusAll(5, date('Y'));
		$finished_companyOrders = Order::getCompanyOrderStatusAll(6, date('Y'));
		
		$new_companyOrders2 = Order::getDirectOrderStatusAll(0, date('Y'));
		$agreement_companyOrders2 = Order::getDirectOrderStatusAll(1, date('Y'));
		$accepted_companyOrders2 = Order::getDirectOrderStatusAll(2, date('Y'));
		$toFactory_companyOrders2 = Order::getDirectOrderStatusAll(4, date('Y'));
		$producing_companyOrders2 = Order::getDirectOrderStatusAll(5, date('Y'));
		$finished_companyOrders2 = Order::getDirectOrderStatusAll(6, date('Y'));
		
		$companyOrders = Order::newCompanyOrders();
		$directOrders = Order::newDirectOrders();
		if($detect->isMobile()) {
			require(ADMIN_TEMPLATE . "admin-home.php");
		} else {
			require(ADMIN_WEB_TEMPLATE . "admin-home.php");
		}
	} elseif($_SESSION['login']['group_id'] == 2) {
		$new_companyOrders = Order::getCompanyOrderStatusAll(0, date('Y'));
		$agreement_companyOrders = Order::getCompanyOrderStatusAll(1, date('Y'));
		$accepted_companyOrders = Order::getCompanyOrderStatusAll(2, date('Y'));
		$toFactory_companyOrders = Order::getCompanyOrderStatusAll(4, date('Y'));
		$producing_companyOrders = Order::getCompanyOrderStatusAll(5, date('Y'));
		$finished_companyOrders = Order::getCompanyOrderStatusAll(6, date('Y'));
		
		$new_companyOrders2 = Order::getDirectOrderStatusAll(0, date('Y'));
		$agreement_companyOrders2 = Order::getDirectOrderStatusAll(1, date('Y'));
		$accepted_companyOrders2 = Order::getDirectOrderStatusAll(2, date('Y'));
		$toFactory_companyOrders2 = Order::getDirectOrderStatusAll(4, date('Y'));
		$producing_companyOrders2 = Order::getDirectOrderStatusAll(5, date('Y'));
		$finished_companyOrders2 = Order::getDirectOrderStatusAll(6, date('Y'));
		
		$companyOrders = Order::newCompanyOrders();
		$directOrders = Order::newDirectOrders();
		if($detect->isMobile()) {
			require(ADMIN_TEMPLATE . "manager-home.php");
		} else {
			require(ADMIN_WEB_TEMPLATE . "manager-home.php");
		}
	} else {
		if($detect->isMobile()) {
			require(ADMIN_TEMPLATE . "factory-home.php");
		} else {
			require(ADMIN_WEB_TEMPLATE . "factory-home.php");
		}
	}
} else {
	header( "Location: index.php" );
}
}

function getProductTypeName($productTypeId) {
	$product_type = ProductType::getProductType($productTypeId);
	return $product_type['title'];
}

?>