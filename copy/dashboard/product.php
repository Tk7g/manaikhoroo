<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/ProductType.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Page.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Mobile_Detect.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'add' :
		add();
		break;
	case 'edit':
		edit();
		break;
	case 'delete':
		delete();
		break;
	default:
		productList();
}

function delete() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		$current_product = ProductType::deleteProduct((int)$_GET['id']);
		if($current_product == 0) {
			header( "Location: product.php?status=error" );
		} else {
			header( "Location: product.php?status=deleteSuccess" );	
		}
	} else {
		header("Location: index.php");	
	}
}

function edit() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		$current_product = ProductType::getProductType((int)$_GET['id']);
		if(isset($_POST['saveProduct'])) {
			ProductType::editProduct($_POST);
			header( "Location: product.php?status=newsSaved" );
		}
		$dataParent = ProductType::getParentList();
		$page_title = 'Бүтээгдэхүүний төрөл засварлах';
		$detect = new Mobile_Detect();
		if($detect->isMobile()) {
		
		} else {
			require(ADMIN_WEB_TEMPLATE . "product/edit.php");	
		}
	} else {
		header("Location: index.php");
	}
}

function add() {
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		if (isset($_POST['saveProduct'])) {
			$news_id = ProductType::addProduct($_POST);
			if($news_id == FALSE) {
				header( "Location: product.php?status=error" );
			} else {
				header( "Location: product.php?status=newsSaved" );	
			}
		}
		$detect = new Mobile_Detect();
		$dataParent = ProductType::getParentList();
		$page_title = 'Бүтээгдэхүүний төрөл нэмэх';
		if($detect->isMobile()) {
		
		} else {
			require(ADMIN_WEB_TEMPLATE . "product/add.php");	
		}
	} else {
		header( "Location: index.php?action=home" );
	}
}

function productList() {
	$detect = new Mobile_Detect();
	if($_SESSION['login']['group_id'] == 1 || $_SESSION['login']['group_id'] == 2) {
		if ( isset( $_GET['status'] ) ) {
    		if ( $_GET['status'] == "newsSaved" ) $result = "Бүтээгдэхүүний төрөл амжилттай хадгалагдлаа.";
    		if ( $_GET['status'] == "error" ) $result = "Алдаа гарсан тул дахин оролдоно уу.";
    		if ( $_GET['status'] == "deleteSuccess" ) $result = "Бүтээгдэхүүний төрөл устгагдлаа.";
  		}
  		$page_title = 'Бүтээгдэхүүний төрөл';
  		$dataParent = ProductType::getParentList();
	} else {
		header( "Location: index.php?action=home" );
	}
	if($detect->isMobile()) {
			
	} else {
		require(ADMIN_WEB_TEMPLATE . "product/list.php");
	}
}

function getProductName($id) {
	$name = ProductType::getProductType($id);
	return $name['title'];
}

?>