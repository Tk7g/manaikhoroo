<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Page.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Order.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Agreement.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Company.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Position.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/ProductType.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Pomp.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/ConcreteType.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Slump.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Mobile_Detect.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'orderInfo':
		orderInfo();
		break;
	case 'orderManager':
		orderManager();
		break;
	case 'orderFactory':
		orderFactory();
		break;
	case 'orderInfoManager':
		orderInfoManager();
		break;
	case 'agreementSubmit':
		agreementSubmit();
		break;
	case 'descSubmit':
		descSubmit();
		break;
	case 'paymentSubmit':
		paymentSubmit();
		break;
	case 'approveOrder':
		approveOrder();
		break;
	case 'cancelOrder':
		cancelOrder();
		break;
	case 'paymentSubmit':
		paymentSubmit();
		break;
	case 'paymentChange':
		paymentChange();
		break;
	case 'orderFactoryInfo':
		orderFactoryInfo();
		break;
	case 'produce':
		produce();
		break;
	case 'progressUpdate':
		progressUpdate();
		break;
	case 'progressFinish':
		progressFinish();
		break;
	case 'companyOrderStat':
		companyOrderStat();
		break;
	case 'searchOrderAll':
		searchOrderAll();
		break;
	case 'searchOrderManager':
		searchOrderManager();
		break;
	case 'searchOrderFactory':
		searchOrderFactory();
		break;
	case 'fileRemoveFactory':
		fileRemoveFactory();
		break;
	case 'selectOrderStat':
		selectOrderStat();
		break;
	case 'orderYearReport':
		orderYearReport();
		break;
	case 'selectYearReport':
		selectYearReport();
		break;
	case 'orderGraphReport':
		orderGraphReport();
		break;
	case 'selectYearGraphReport':
		selectYearGraphReport();
		break;
	case 'orderRevenueReport':
		orderRevenueReport();
		break;
	case 'selectYearRevenueReport':
		selectYearRevenueReport();
		break;
	case 'orderDateGraphReport':
		orderDateGraphReport();
		break;
	case 'selectDateGraphReport':
		selectDateGraphReport();
		break;
	case 'sendToFactory':
		sendToFactory();
		break;
	default:
		orderAll();
}

function selectDateGraphReport() {
	if (isset($_POST['selectYear'])) {
		header( "Location: order.php?action=orderDateGraphReport&date1=".$_POST['order_date1']."&date2=".$_POST['order_date2']."&type=".$_POST['type']."" );
	}
}

function orderDateGraphReport() {
	User::allowExecute(1);
	if(isset($_GET['date1'])) {
		$current_date1 = $_GET['date1'];
	} else {
		$current_date1 = date('Y-m-d');
	}
	if(isset($_GET['date2'])) {
		$current_date2 = $_GET['date2'];
	} else {
		$current_date2 = date('Y-m-d', strtotime($current_date1. ' + 6 days'));;
	}
	if(isset($_GET['type'])) {
		$type = $_GET['type'];
	} else {
		$type = 0;
	}
	if(isset($_GET['type'])) {
		if($_GET['type'] == 1) {
			$page_title = $current_date1.'-c '.$current_date2.' оны гэрээт захиалгын орлогын тайлан';	
		} elseif($_GET['type'] == 2) {
			$page_title = $current_date1.'-c '.$current_date2.' оны гэрээт бус захиалгын орлогын тайлан';
		} else {
			$page_title = $current_date1.'-c '.$current_date2.' оны захиалгын орлогын тайлан';
		}
	} else {
		$page_title = $current_date1.'-c '.$current_date2.'-ны хооронд /график тайлан/';
	}
	$current_days = (strtotime($current_date2) - strtotime($current_date1)) / (60 * 60 * 24);
	for($k=0; $k<=$current_days; $k++) {
		$order[$k] = Order::getDateOrders(date('Y-m-d', strtotime($current_date1. " + $k days")), $type);
		$totalDateRevenue[$k] = 0;
		$totalDateSize[$k] = 0;
		foreach($order[$k] as $ord) {
			if($ord['total_price'] != NULL) {
				$totalDateRevenue[$k] = $totalDateRevenue[$k] + $ord['total_price'];	
			}
			$totalDateSize[$k] = $totalDateSize[$k] + $ord['size1'];
		}
	}
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "order/orderDateGraphReport.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderDateGraphReport.php");
	}
}

function selectYearRevenueReport() {
	if (isset($_POST['selectYear'])) {
		header( "Location: order.php?action=orderRevenueReport&year=".$_POST['year']."&type=".$_POST['type']."" );
	}
}

function orderRevenueReport() {
	User::allowExecute(1);
	if(isset($_GET['year'])) {
		$current_year = $_GET['year'];
	} else {
		$current_year = date('Y');
	}
	if(isset($_GET['type'])) {
		$type = $_GET['type'];
	} else {
		$type = 0;
	}
	for($k=1;$k<=12;$k++) {
		$orders[$k] = Order::getYearOrders($current_year, $k, $type);	
		$monthOrderRevenue[$k] = 0;
		$monthOrderSize[$k] = 0;
		foreach($orders[$k] as $order) {
			$monthOrderRevenue[$k] = $monthOrderRevenue[$k] + $order['total_price'];
			$monthOrderSize[$k] = $monthOrderSize[$k] + $order['size1'];
		}
	}
	if(isset($_GET['type'])) {
		if($_GET['type'] == 1) {
			$page_title = $current_year.' оны гэрээт захиалгын орлогын тайлан';	
		} elseif($_GET['type'] == 2) {
			$page_title = $current_year.' оны гэрээт бус захиалгын орлогын тайлан';
		} else {
			$page_title = $current_year.' оны захиалгын орлогын тайлан';
		}
	} else {
		$page_title = $current_year.' оны захиалгын орлогын тайлан';
	}
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "order/orderRevenueReport.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderRevenueReport.php");
	}
}

function orderGraphReport() {
	User::allowExecute(1);
	if(isset($_GET['year'])) {
		$current_year = $_GET['year'];
	} else {
		$current_year = date('Y');
	}
	if(isset($_GET['type'])) {
		$type = $_GET['type'];
	} else {
		$type = 0;
	}
	for($k=1;$k<=12;$k++) {
		$orders[$k] = Order::getYearOrders($current_year, $k, $type);	
		$monthOrderRevenue[$k] = 0;
		$monthOrderSize[$k] = 0;
		foreach($orders[$k] as $order) {
			$monthOrderRevenue[$k] = $monthOrderRevenue[$k] + $order['total_price'];
			$monthOrderSize[$k] = $monthOrderSize[$k] + $order['size1'];
		}
	}
	if(isset($_GET['type'])) {
		if($_GET['type'] == 1) {
			$page_title = $current_year.' оны гэрээт захиалгын график тайлан';	
		} elseif($_GET['type'] == 2) {
			$page_title = $current_year.' оны гэрээт бус захиалгын график тайлан';
		} else {
			$page_title = $current_year.' оны захиалгын график тайлан';
		}
	} else {
		$page_title = $current_year.' оны захиалгын график тайлан';
	}
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "order/orderGraphReport.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderGraphReport.php");
	}
}

function selectYearGraphReport() {
	if (isset($_POST['selectYear'])) {
		header( "Location: order.php?action=orderGraphReport&year=".$_POST['year']."&type=".$_POST['type']."" );
	}
}

function selectYearReport() {
	if (isset($_POST['selectYear'])) {
		header( "Location: order.php?action=orderYearReport&year=".$_POST['year']."&type=".$_POST['type']."" );
	}
}

function orderYearReport() {
	User::allowExecute(1);
	if(isset($_GET['year'])) {
		$current_year = $_GET['year'];
	} else {
		$current_year = date('Y');
	}
	if(isset($_GET['type'])) {
		$type = $_GET['type'];
	} else {
		$type = 0;
	}
	for($k=1;$k<=12;$k++) {
		$orders[$k] = Order::getYearOrders($current_year, $k, $type);	
	}
	if(isset($_GET['type'])) {
		if($_GET['type'] == 1) {
			$page_title = $current_year.' оны гэрээт захиалгын тайлан';	
		} elseif($_GET['type'] == 2) {
			$page_title = $current_year.' оны гэрээт бус захиалгын тайлан';
		} else {
			$page_title = $current_year.' оны захиалгын тайлан';
		}
	} else {
		$page_title = $current_year.' оны захиалгын тайлан';
	}
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "order/orderYearReport.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderYearReport.php");
	}
}

function fileRemoveFactory() {
	$current_order = Order::getOrder($_GET['id']);
	$folder = $_GET['folder'];
	switch($folder){
		case 'quality_cert':
			$current_file = $current_order['quality_cert'];
			break;
		case 'slump_img':
			$current_file = $current_order['slump_img'];
			break;
		case 'research_page':
			$current_file = $current_order['research_page'];
			break;
		case 'concrete_reply7':
			$current_file = $current_order['concrete_reply7'];
			break;
		case 'concrete_reply14':
			$current_file = $current_order['concrete_reply14'];
			break;
		case 'concrete_reply28':
			$current_file = $current_order['concrete_reply28'];
			break;
	}
	$delete_file = Order::fileRemove($current_file, $folder, $_GET['id']);
	if($delete_file == 0) {
		if($_SESSION['login']['group_id'] == 1) {
			header( "Location: order.php?action=orderInfo&id=".$_GET['id']."&status=error" );
		} else {
			header( "Location: order.php?action=orderFactoryInfo&id=".$_GET['id']."&status=error" );	
		}
	} else {
		if($_SESSION['login']['group_id'] == 1) {
			header( "Location: order.php?action=orderInfo&id=".$_GET['id']."&status=fileRemoved" );
		} else {
			header( "Location: order.php?action=orderFactoryInfo&id=".$_GET['id']."&status=fileRemoved" );	
		}
	}
}

function selectOrderStat() {
	if (isset($_POST['selectYear'])) {
		header( "Location: order.php?action=companyOrderStat&id=".$_POST['id']."&year=".$_POST['year']."" );
	}
}

function companyOrderStat() {
	User::allowExecute(1);
	$company = Company::getCompany($_GET['id']);
	$yearOrders = Order::getCompanyYearOrders($company['id'], $_GET['year']);
	$yearTotal = 0;
	$yearTotalSize = 0;
	$totalOrder = 0;
	$minOrder = 0;
	$maxOrder = 0;
	foreach($yearOrders as $yearOrder) {
		$yearTotal = $yearTotal + $yearOrder['total_price'];
		$yearTotalSize = $yearTotalSize + $yearOrder['size1'];
		$totalOrder = $totalOrder + 1;
		if($minOrder == 0) {
			$minOrder = $yearOrder['total_price'];
			$maxOrder = $yearOrder['total_price'];
		}
		if($minOrder > $yearOrder['total_price']) {
			$minOrder = $yearOrder['total_price'];
		}
		if($maxOrder < $yearOrder['total_price']) {
			$maxOrder = $yearOrder['total_price'];
		}
	}
	$monthTotal = array();
	for($i=1;$i<=12;$i++) {
		$number_of_days = cal_days_in_month(CAL_GREGORIAN, $i, $_GET['year']);
		$monthOrders[$i] = Order::getCompanyMonthOrders($company['id'], $_GET['year'].'-'.$i.'-01', $_GET['year'].'-'.$i.'-'.$number_of_days);
		$monthTotal[$i] = 0;
		$monthTotalSize[$i] = 0;
		$order_total[$i] = 0;
		foreach($monthOrders[$i] as $monthOrder) {
			$monthTotal[$i] = $monthTotal[$i] + $monthOrder['total_price'];
			$monthTotalSize[$i] = $monthTotalSize[$i] + $monthOrder['size1'];
			$order_total[$i] = $order_total[$i] + 1;
		}
	}
	$page_title = 'Статистик: '.$company['name'];
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "order/companyOrderStat.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/companyOrderStat.php");
	}
}

function cancelOrder() {
	User::allowExecute(1);
	$result = Order::cancelOrder($_GET['id']);
	if($result == 0) {
		header( "Location: order.php?action=orderInfo&id=".$_GET['id']."&status=error" );	
	} else {
		header( "Location: order.php?action=orderInfo&id=".$_GET['id']."&status=cancelSuccess" );	
	}
}

function approveOrder() {
	User::allowExecute(1);
	$result = Order::approveOrder($_GET['id']);
	if($result == 0) {
		header( "Location: order.php?action=orderInfo&id=".$_GET['id']."&status=error" );	
	} else {
		header( "Location: order.php?action=orderInfo&id=".$_GET['id']."&status=approveSuccess" );	
	}
}

function produce() {
	User::allowExecute(array(1,3));
	if (isset($_POST['saveOrder'])) {
		$order = new Order;
		if($_POST['concrete_type_id'] == 'textOption') {
			$concreteType = $_POST['concrete_type_text'];
		} else {
			$concreteType = $_POST['concrete_type_id'];
		}
		$order_response = $order->produce($concreteType, $_POST['id']);
		if($order_response == 0) {
			header( "Location: order.php?action=orderFactoryInfo&id=".$_POST['id']."&status=error" );
		} else {
			$status_response = $order->changeStatus($_POST['id'], 5);
			if($status_response == 0) {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: order.php?action=orderInfo&".$_POST['id']."&status=error" );
				} else {
					header( "Location: order.php?action=orderFactoryInfo&".$_POST['id']."&status=error" );
				}
			} else {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=produceSuccess" );
				} else {
					header( "Location: order.php?action=orderFactoryInfo&id=".$_POST['id']."&status=produceSuccess" );
				}	
			}
		}	
	}
}

function progressFinish() {
	User::allowExecute(array(1,3));
	if(isset($_POST['saveOrder'])) {
		$order = new Order;
		$order_response = $order->progressFinish($_POST, $_FILES);
		if($order_response == 0) {
			header( "Location: order.php?action=orderFactoryInfo&id=".$_POST['id']."&status=error" );
		} else {
			$status_response = $order->changeStatus($_POST['id'], 6);
			if($status_response == 0) {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: order.php?action=orderInfo&".$_POST['id']."&status=error" );
				} else {
					header( "Location: order.php?action=orderFactoryInfo&".$_POST['id']."&status=error" );	
				}
			} else {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=finishSuccess" );
				} else {
					header( "Location: order.php?action=orderFactoryInfo&id=".$_POST['id']."&status=finishSuccess" );
				}
			}
		}
	}
}

function progressUpdate() {
	User::allowExecute(array(1,3));
	if (isset($_POST['saveOrder'])) {
		$order = new Order;
		$order_response = $order->progressUpdate($_POST);
		if($order_response == 0) {
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=error" );
			} else {
				header( "Location: order.php?action=orderFactoryInfo&id=".$_POST['id']."&status=error" );
			}
		} else {
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=produceSuccess" );	
			} else {
				header( "Location: order.php?action=orderFactoryInfo&id=".$_POST['id']."&status=produceSuccess" );	
			}
		}	
	}
}

function searchOrderAll() {
	$getAdd = "";
	if (isset($_POST['searchOrder'])) {
		if(isset($_POST['status'])) {
			$getAdd .= '&status='.$_POST['status']; 
		}
		if(isset($_POST['company_id'])) {
			$getAdd .= '&company='.$_POST['company_id'];
		}
		if(isset($_POST['product_type_id'])) {
			$getAdd .= '&product='.$_POST['product_type_id'];
		}
		header( "Location: order.php?page=1".$getAdd );	
	}
}

function searchOrderManager() {
	$getAdd = "";
	if (isset($_POST['searchOrder'])) {
		if(isset($_POST['status'])) {
			$getAdd .= '&status='.$_POST['status']; 
		}
		if(isset($_POST['company_id'])) {
			$getAdd .= '&company='.$_POST['company_id'];
		}
		if(isset($_POST['product_type_id'])) {
			$getAdd .= '&product='.$_POST['product_type_id'];
		}
		header( "Location: order.php?action=orderManager&page=1".$getAdd );	
	}
}

function searchOrderFactory() {
	$getAdd = "";
	if (isset($_POST['searchOrder'])) {
		if(isset($_POST['company_id'])) {
			$getAdd .= '&company='.$_POST['company_id'];
		}
		if(isset($_POST['product_type_id'])) {
			$getAdd .= '&product='.$_POST['product_type_id'];
		}
		header( "Location: order.php?action=orderFactory&page=1".$getAdd );	
	}
}

function orderAll() {
	User::allowExecute(1);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "success" ) $result = "Захиалгын мэдээлэл амжилттай хадгалагдлааа.";
    	if ( $_GET['status'] == "editSuccess" ) $result = "Захиалгын мэдээлэл амжилттай засварлагдлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $result = "Захиалгын мэдээлэл устгагдлаа.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
  	}
  	if(isset($_GET['page'])) {
		if($_GET['page'] == 1) {
			if(isset($_GET['status'])) {
				$getStatus = $_GET['status'];
			} else {
				$getStatus = NULL;
			}
			if(isset($_GET['company'])) {
				$getCompany = $_GET['company'];
			} else {
				$getCompany = NULL;
			}
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$orders = Order::orderAll(0, 10, $getStatus, $getCompany, $getProduct);
		} elseif($_GET['page'] > 1) {
			if(isset($_GET['status'])) {
				$getStatus = $_GET['status'];
			} else {
				$getStatus = NULL;
			}
			if(isset($_GET['company'])) {
				$getCompany = $_GET['company'];
			} else {
				$getCompany = NULL;
			}
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$from = ($_GET['page'] - 1)*10;
			$orders = Order::orderAll($from, 10, $getStatus, $getCompany, $getProduct);
		}
	} else {
		$orders = Order::orderAll(0, 10, NULL, NULL, NULL);
	}
	$productParents = ProductType::getParentList();
	$companies = Company::getList();
	$total_pages = Page::getCompanyOrderTotalRows();
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
  	$page_title = 'Гэрээт захиалгууд';
  	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "order/orderGereetAll.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderGereetAll.php");
	}
}

function orderManager() {
	User::allowExecute(array(1,2));
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "success" ) $result = "Захиалгын мэдээлэл амжилттай хадгалагдлааа.";
    	if ( $_GET['status'] == "editSuccess" ) $result = "Захиалгын мэдээлэл амжилттай засварлагдлаа.";
    	if ( $_GET['status'] == "deleteSuccess" ) $result = "Захиалгын мэдээлэл устгагдлаа.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
  	}
	if(isset($_GET['page'])) {
		if($_GET['page'] == 1) {
			if(isset($_GET['status'])) {
				$getStatus = $_GET['status'];
			} else {
				$getStatus = NULL;
			}
			if(isset($_GET['company'])) {
				$getCompany = $_GET['company'];
			} else {
				$getCompany = NULL;
			}
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$orders = Order::orderAll(0, 10, $getStatus, $getCompany, $getProduct);
		} elseif($_GET['page'] > 1) {
			if(isset($_GET['status'])) {
				$getStatus = $_GET['status'];
			} else {
				$getStatus = NULL;
			}
			if(isset($_GET['company'])) {
				$getCompany = $_GET['company'];
			} else {
				$getCompany = NULL;
			}
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$from = ($_GET['page'] - 1)*10;
			$orders = Order::orderAll($from, 10, $getStatus, $getCompany, $getProduct);
		}
	} else {
		$orders = Order::orderAll(0, 10, NULL, NULL, NULL);
	}
	$productParents = ProductType::getParentList();
	$companies = Company::getList();
	$total_pages = Page::getCompanyOrderTotalRows("hu_orders");
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
	$page_title = 'Гэрээт захиалгууд';
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "order/orderManager.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderManager.php");
	}
}

function orderFactory() {
	User::allowExecute(3);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "produceSuccess" ) $result = "Захиалгыг үйлдвэрлэж эхэллээ.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
    	if ( $_GET['status'] == "fileRemoved" ) $result = "Файл амжилттай устгагдлаа.";
  	}
	if(isset($_GET['page'])) {
		if($_GET['page'] == 1) {
			if(isset($_GET['company'])) {
				$getCompany = $_GET['company'];
			} else {
				$getCompany = NULL;
			}
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$orders = Order::orderFactory(0, 10, $getCompany, $getProduct);
		} elseif($_GET['page'] > 1) {
			if(isset($_GET['company'])) {
				$getCompany = $_GET['company'];
			} else {
				$getCompany = NULL;
			}
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$from = ($_GET['page'] - 1)*10;
			$orders = Order::orderFactory($from, 10, $getCompany, $getProduct);
		}
	} else {
		$orders = Order::orderFactory(0, 10, NULL, NULL);
	}
	$productParents = ProductType::getParentList();
	$companies = Company::getList();
	$total_pages = Page::getCompanyOrderFactoryTotalRows("hu_orders");
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
	$page_title = 'Гэрээт захиалгууд';
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
		require(ADMIN_TEMPLATE . "order/orderFactory.php");
	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderFactory.php");
	}
}

function orderFactoryInfo() {
	User::allowExecute(3);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "produceSuccess" ) $result = "Үйлдвэрлэлийн явц шинэчлэгдлээ.";
    	if ( $_GET['status'] == "finishSuccess" ) $result = "Захиалга гүйцэтгэгдэж дууслаа.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
  	}
  	$order = Order::getOrder($_GET['id']);
  	$concrete_types = ConcreteType::getList();
	switch ( $order['status'] ) {
	case 4:
		$command_title = 'Үйлдвэрлэх';
		break;
	case 5:
		$command_title = 'Захиалгын явц';
		break;
	case 6:
		$command_title = 'Захиалга дуусгах';
		break;
	}
	$page_title = 'Захиалгын № '.$order['id'];
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
		require(ADMIN_TEMPLATE . "order/orderFactoryInfo.php");
	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderFactoryInfo.php");
	}
}

function orderInfo() {
	User::allowExecute(1);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "descSubmitSuccess" ) $result = "Нэмэлт тайлбар амжилттай илгээгдлээ.";
    	if ( $_GET['status'] == "approveSuccess" ) $result = "Захиалгыг зөвшөөрлөө.";
    	if ( $_GET['status'] == "cancelSuccess" ) $result = "Захиалгаас татгалзлаа.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
    	if ( $_GET['status'] == "agreementIdSuccess" ) $result = "Захиалгад гэрээний дугаар олголоо.";
    	if ( $_GET['status'] == "factorySendSuccess" ) $result = "Захиалга үйлдвэр рүү илгээгдлээ.";
    	if ( $_GET['status'] == "produceSuccess" ) $result = "Үйлдвэрлэлийн явц шинэчлэгдлээ.";
    	if ( $_GET['status'] == "finishSuccess" ) $result = "Захиалга гүйцэтгэгдэж дууслаа.";
    	if ( $_GET['status'] == "paymentChangeSuccess" ) $result = "Төлбөрийн мэдээлэл амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "agreementIdExist" ) $result = "Таны оруулсан гэрээний № давхцаж байна.";
  	}
	$order = Order::getOrder($_GET['id']);
	$company = Company::getCompany($order['company_id']);
	$checkAgreement = Agreement::getAgreement($company['id']);
	if($order['agreement_id'] != NULL) {
		$agreementInfo = Agreement::getAgreementInfo($order['agreement_id']);	
		$agreementAllOrders = Order::getAgreementOrders($order['agreement_id']);
		$totalOrderedSize = 0;
		$totalProducedSize = 0;
		foreach($agreementAllOrders as $agAllOrder) {
			$totalProducedSize = $totalProducedSize + $agAllOrder['produced'];
			$totalOrderedSize = $totalOrderedSize + $agAllOrder['size1'];
		}
	}
  	$concrete_types = ConcreteType::getList();
	switch ( $order['status'] ) {
	case 0:
		$command_title = 'Захиалгын явц';
		break;
	case 1:
		$command_title = 'Захиалгыг зөвшөөрөх';
		break;
	case 2:
		$command_title = 'Захиалгын явц';
		break;
	case 3:
		$command_title = 'Захиалгаас татгалзсан';
		break;
	case 4:
		$command_title = 'Үйлдвэрт шилжсэн';
		break;
	case 5:
		$command_title = 'Үйлдвэрлэж эхэлсэн';
		break;
	case 6:
		$command_title = 'Үйлдвэрлэж дууссан';
		break;
	}
	$page_title = 'Захиалгын № '.$order['id'];
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
  		require(ADMIN_TEMPLATE . "order/orderInfo.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderInfo.php");
	}
}

function orderInfoManager() {
	User::allowExecute(2);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "agreementIdExist" ) $result = "Гэрээний дугаар давхардсан тул өөр дугаар оруулна уу.";
    	if ( $_GET['status'] == "agreementIdSuccess" ) $result = "Захиалга админ руу илгээгдлээ. Админы зөвшөөрлийг хүлээнэ үү.";
    	if ( $_GET['status'] == "factorySendSuccess" ) $result = "Захиалга үйлдвэр рүү илгээгдлээ.";
    	if ( $_GET['status'] == "paymentChangeSuccess" ) $result = "Захиалгын төлбөрийн мэдээлэл амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
  	}
	$order = Order::getOrder($_GET['id']);
	$company = Company::getCompany($order['company_id']);
	$checkAgreement = Agreement::getAgreement($company['id']);
	if($order['agreement_id'] != NULL) {
		$agreementInfo = Agreement::getAgreementInfo($order['agreement_id']);	
		$agreementAllOrders = Order::getAgreementOrders($order['agreement_id']);
		$totalOrderedSize = 0;
		$totalProducedSize = 0;
		foreach($agreementAllOrders as $agAllOrder) {
			$totalProducedSize = $totalProducedSize + $agAllOrder['produced'];
			$totalOrderedSize = $totalOrderedSize + $agAllOrder['size1'];
		}
	}
	if($order['checked'] == 0) {
		$result = Order::orderChecked($order['id']);
		if($result == 0) {
			header( "Location: order.php?action=orderManager" );
		}
	}
	switch ( $order['status'] ) {
	case 0:
		$command_title = 'Гэрээний № авах';
		break;
	case 1:
		$command_title = 'Захиалгын явц';
		break;
	case 2:
		$command_title = 'Зөвшөөрсөн';
		break;
	case 3:
		$command_title = 'Татгалзлаа';
		break;
	case 4:
		$command_title = 'Үйлдвэрт шилжсэн';
		break;
	case 5:
		$command_title = 'Үйлдвэрлэж эхэлсэн';
		break;
	case 6:
		$command_title = 'Үйлдвэрлэж дууссан';
		break;
	}
	$page_title = 'Захиалгын № '.$order['id'];
	$detect = new Mobile_Detect();
	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "order/orderInfoManager.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "order/orderInfoManager.php");
	}
}

function agreementSubmit() {
	User::allowExecute(array(1,2));
	if (isset($_POST['saveOrder'])) {
		$checkAgreementId = Order::checkAgreementId($_POST['agreement_id']);
		if($checkAgreementId == NULL) {
			$order = new Order;
			$order_response = $order->agreementSubmit($_POST, $_FILES); 
			if($order_response == FALSE) {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=error" );
				} else {
					header( "Location: order.php?action=orderInfoManager&id=".$_POST['id']."&status=error" );
				}
			} else {
				$status_response = $order->changeStatus($_POST['id'], 7);
				$changeAgreementId = order::changeAgreementId($order_response, $_POST['id']);
				if($status_response == 0) {
					if($_SESSION['login']['group_id'] == 1) {
						header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=error" );
					} else {
						header( "Location: order.php?action=orderInfoManagerid=&".$_POST['id']."&status=error" );
					}	
				} else {
					if($_SESSION['login']['group_id'] == 1) {
						header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=agreementIdSuccess" );	
					} else {
						header( "Location: order.php?action=orderInfoManager&id=".$_POST['id']."&status=agreementIdSuccess" );	
					}
				}
			}	
		} else {
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=agreementIdExist" );
			} else {
				header( "Location: order.php?action=orderInfoManager&id=".$_POST['id']."&status=agreementIdExist" );
			}
		}
	}
}

function descSubmit() {
	User::allowExecute(1);
	if (isset($_POST['saveOrder'])) {
		$order = new Order;
		$desc_response = Order::descSubmit($_POST);
		if($desc_response == 0) {
			header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=error" );
		} else {
			header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=descSubmitSuccess" );	
		}	
	}
}

function paymentChange() {
	User::allowExecute(array(1,2));
	if (isset($_POST['saveOrder'])) {
		$order = new Order;
		$desc_response = Order::paymentSubmit($_POST);
		if($desc_response == 0) {
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=error" );
			} else {
				header( "Location: order.php?action=orderInfoManager&id=".$_POST['id']."&status=error" );
			}
		} else {			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=paymentChangeSuccess" );
			} else {
				header( "Location: order.php?action=orderInfoManager&id=".$_POST['id']."&status=paymentChangeSuccess" );
			}
		}	
	}
}

function sendToFactory() {
	User::allowExecute(array(1,2));
	$order = new Order;
	$status_response = $order->changeStatus($_GET['id'], 4);
	if($status_response == 0) {
		if($_SESSION['login']['group_id'] == 1) {
			header( "Location: order.php?action=orderInfo&".$_GET['id']."&status=error" );
		} else {
			header( "Location: order.php?action=orderInfoManager&".$_GET['id']."&status=error" );
		}
	} else {
		if($_SESSION['login']['group_id'] == 1) {
			header( "Location: order.php?action=orderInfo&id=".$_GET['id']."&status=factorySendSuccess" );	
		} else {
			header( "Location: order.php?action=orderInfoManager&id=".$_GET['id']."&status=factorySendSuccess" );	
		}
	}	
}

function paymentSubmit() {
	User::allowExecute(array(1,2));
	if (isset($_POST['saveOrder'])) {
		$order = new Order;
		$desc_response = Order::paymentSubmit($_POST);
		if($desc_response == 0) {
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=error" );	
			} else {
				header( "Location: order.php?action=orderInfoManager&id=".$_POST['id']."&status=error" );
			}
		} else {
			$status_response = $order->changeStatus($_POST['id'], 1);
			if($status_response == 0) {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: order.php?action=orderInfo&".$_POST['id']."&status=error" );
				} else {
					header( "Location: order.php?action=orderInfoManager&".$_POST['id']."&status=error" );
				}
			} else {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: order.php?action=orderInfo&id=".$_POST['id']."&status=paymentChangeSuccess" );	
				} else {
					header( "Location: order.php?action=orderInfoManager&id=".$_POST['id']."&status=paymentChangeSuccess" );	
				}
			}	
		}	
	}
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
	case 7:
		$color = '#FFFFFF';
		break;
	}
	return $color;
}

function getPositionName($positionid) {
	$position = Position::getPosition($positionid);
	return $position['title'];
}

function getProductTypeName($productTypeId) {
	$product_type = ProductType::getProductType($productTypeId);
	return $product_type['title'];
}

function getPompName($pompId) {
	$pomp = Pomp::getPomp($pompId);
	return $pomp['title'];
}

function getConcreteTypeName($concreteTypeId) {
	$concreteType = ConcreteType::getConcreteType($concreteTypeId);
	return $concreteType['title'];
}

function getSlumpTypeName($slumpTypeId) {
	$slumpType = Slump::getSlump($slumpTypeId);
	return $slumpType['title'];
}

function getPaymentStatusName($payment) {
	if($payment == 1) {
		$payment_status = 'Бэлнээр';
	} else {
		$payment_status = 'Гэрээний дагуу';
	}
	return $payment_status;
}

?>