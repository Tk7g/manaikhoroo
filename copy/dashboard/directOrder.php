<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Page.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Order.class.php");
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
	default:
		orderAll();
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
			header( "Location: directOrder.php?action=orderInfo&id=".$_GET['id']."&status=error" );
		} else {
			header( "Location: directOrder.php?action=orderFactoryInfo&id=".$_GET['id']."&status=error" );	
		}
	} else {
		if($_SESSION['login']['group_id'] == 1) {
			header( "Location: directOrder.php?action=orderInfo&id=".$_GET['id']."&status=fileRemoved" );
		} else {
			header( "Location: directOrder.php?action=orderFactoryInfo&id=".$_GET['id']."&status=fileRemoved" );	
		}
	}
}

function cancelOrder() {
	User::allowExecute(1);
	$result = Order::cancelOrder($_GET['id']);
	if($result == 0) {
		header( "Location: directOrder.php?action=orderInfo&id=".$_GET['id']."&status=error" );	
	} else {
		header( "Location: directOrder.php?action=orderInfo&id=".$_GET['id']."&status=cancelSuccess" );	
	}
}

function approveOrder() {
	User::allowExecute(1);
	$result = Order::approveOrder($_GET['id']);
	if($result == 0) {
		header( "Location: directOrder.php?action=orderInfo&id=".$_GET['id']."&status=error" );	
	} else {
		header( "Location: directOrder.php?action=orderInfo&id=".$_GET['id']."&status=approveSuccess" );	
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
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=error" );
			} else {
				header( "Location: directOrder.php?action=orderFactoryInfo&id=".$_POST['id']."&status=error" );
			}
		} else {
			$status_response = $order->changeStatus($_POST['id'], 5);
			if($status_response == 0) {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: directOrder.php?action=orderInfo&".$_POST['id']."&status=error" );
				} else {
					header( "Location: directOrder.php?action=orderFactoryInfo&".$_POST['id']."&status=error" );
				}
			} else {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=produceSuccess" );
				} else {
					header( "Location: directOrder.php?action=orderFactoryInfo&id=".$_POST['id']."&status=produceSuccess" );
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
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=error" );
			} else {
				header( "Location: directOrder.php?action=orderFactoryInfo&id=".$_POST['id']."&status=error" );
			}
		} else {
			$status_response = $order->changeStatus($_POST['id'], 6);
			if($status_response == 0) {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: directOrder.php?action=orderInfo&".$_POST['id']."&status=error" );
				} else {
					header( "Location: directOrder.php?action=orderFactoryInfo&".$_POST['id']."&status=error" );	
				}
			} else {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=finishSuccess" );
				} else {
					header( "Location: directOrder.php?action=orderFactoryInfo&id=".$_POST['id']."&status=finishSuccess" );
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
				header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=error" );
			} else {
				header( "Location: directOrder.php?action=orderFactoryInfo&id=".$_POST['id']."&status=error" );
			}
		} else {
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=produceSuccess" );	
			} else {
				header( "Location: directOrder.php?action=orderFactoryInfo&id=".$_POST['id']."&status=produceSuccess" );	
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
		if(isset($_POST['product_type_id'])) {
			$getAdd .= '&product='.$_POST['product_type_id'];
		}
		header( "Location: directOrder.php?page=1".$getAdd );	
	}
}

function searchOrderManager() {
	$getAdd = "";
	if (isset($_POST['searchOrder'])) {
		if(isset($_POST['status'])) {
			$getAdd .= '&status='.$_POST['status']; 
		}
		if(isset($_POST['product_type_id'])) {
			$getAdd .= '&product='.$_POST['product_type_id'];
		}
		header( "Location: directOrder.php?action=orderManager&page=1".$getAdd );	
	}
}

function searchOrderFactory() {
	$getAdd = "";
	if (isset($_POST['searchOrder'])) {
		if(isset($_POST['product_type_id'])) {
			$getAdd .= '&product='.$_POST['product_type_id'];
		}
		header( "Location: directOrder.php?action=orderFactory&page=1".$getAdd );	
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
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$orders = Order::directOrderAll(0, 10, $getStatus, $getProduct);
		} elseif($_GET['page'] > 1) {
			if(isset($_GET['status'])) {
				$getStatus = $_GET['status'];
			} else {
				$getStatus = NULL;
			}
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$from = ($_GET['page'] - 1)*10;
			$orders = Order::directOrderAll($from, 10, $getStatus, $getProduct);
		}
	} else {
		$orders = Order::directOrderAll(0, 10, NULL, NULL);
	}
	$productParents = ProductType::getParentList();
	$total_pages = Page::getDirectOrderTotalRows();
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
  	$page_title = 'Гэрээт бус захиалгууд';
  	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "directOrder/orderAll.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "directOrder/orderAll.php");
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
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$orders = Order::directOrderAll(0, 10, $getStatus, $getProduct);
		} elseif($_GET['page'] > 1) {
			if(isset($_GET['status'])) {
				$getStatus = $_GET['status'];
			} else {
				$getStatus = NULL;
			}
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$from = ($_GET['page'] - 1)*10;
			$orders = Order::directOrderAll($from, 10, $getStatus, $getProduct);
		}
	} else {
		$orders = Order::directOrderAll(0, 10, NULL, NULL);
	}
	$productParents = ProductType::getParentList();
	$total_pages = Page::getDirectOrderTotalRows("hu_orders");
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
	$page_title = 'Гэрээт бус захиалгууд';
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
 		require(ADMIN_TEMPLATE . "directOrder/orderManager.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "directOrder/orderManager.php");
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
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$orders = Order::directOrderFactory(0, 10, $getProduct);
		} elseif($_GET['page'] > 1) {
			if(isset($_GET['product'])) {
				$getProduct = $_GET['product'];
			} else {
				$getProduct = NULL;
			}
			$from = ($_GET['page'] - 1)*10;
			$orders = Order::directOrderFactory($from, 10, $getProduct);
		}
	} else {
		$orders = Order::directOrderFactory(0, 10, NULL);
	}
	$productParents = ProductType::getParentList();
	$companies = Company::getList();
	$total_pages = Page::getDirectOrderFactoryTotalRows("hu_orders");
	$total_pagination = ceil($total_pages['COUNT(*)']/10);
	$page_title = 'Гэрээт бус захиалгууд';
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
		require(ADMIN_TEMPLATE . "directOrder/orderFactory.php");
	} else {
		require(ADMIN_WEB_TEMPLATE . "directOrder/orderFactory.php");
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
		require(ADMIN_TEMPLATE . "directOrder/orderFactoryInfo.php");
	} else {
		require(ADMIN_WEB_TEMPLATE . "directOrder/orderFactoryInfo.php");
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
    	if ( $_GET['status'] == "paymentSubmitSuccess" ) $result = "Захиалга үйлдвэр рүү илгээгдлээ.";
    	if ( $_GET['status'] == "produceSuccess" ) $result = "Үйлдвэрлэлийн явц шинэчлэгдлээ.";
    	if ( $_GET['status'] == "finishSuccess" ) $result = "Захиалга гүйцэтгэгдэж дууслаа.";
  	}
	$order = Order::getOrder($_GET['id']);
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
	$page_title = 'Гэрээт бус захиалгын № '.$order['id'];
	$detect = new Mobile_Detect();
  	if($detect->isMobile()) {
  		require(ADMIN_TEMPLATE . "directOrder/orderInfo.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "directOrder/orderInfo.php");
	}
}

function orderInfoManager() {
	User::allowExecute(2);
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "agreementIdExist" ) $result = "Гэрээний дугаар давхардсан тул өөр дугаар оруулна уу.";
    	if ( $_GET['status'] == "agreementIdSuccess" ) $result = "Захиалга админ руу илгээгдлээ. Админы зөвшөөрлийг хүлээнэ үү.";
    	if ( $_GET['status'] == "paymentSubmitSuccess" ) $result = "Захиалга үйлдвэр рүү илгээгдлээ.";
    	if ( $_GET['status'] == "paymentChangeSuccess" ) $result = "Захиалгын төлбөрийн мэдээлэл өөрчлөгдлөө.";
    	if ( $_GET['status'] == "error" ) $result = "Алдаа гарлаа дахин оролдоно уу.";
  	}
	$order = Order::getOrder($_GET['id']);
	if($order['checked'] == 0) {
		$result = Order::orderChecked($order['id']);
		if($result == 0) {
			header( "Location: directOrder.php?action=orderManager" );
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
 		require(ADMIN_TEMPLATE . "directOrder/orderInfoManager.php");
  	} else {
		require(ADMIN_WEB_TEMPLATE . "directOrder/orderInfoManager.php");
	}
}

function agreementSubmit() {
	User::allowExecute(array(1,2));
	if (isset($_POST['saveOrder'])) {
		$checkAgreementId = Order::checkAgreementId($_POST['agreement_id']);
		if($checkAgreementId == NULL) {
			$order = new Order;
			$order_response = $order->agreementSubmit($_POST, $_FILES);
			if($order_response == 0) {
				header( "Location: order.php?action=directOrderInfoManager&id=".$_POST['id']."&status=error" );
			} else {
				$status_response = $order->changeStatus($_POST['id'], 1);
				if($status_response == 0) {
					if($_SESSION['login']['group_id'] == 1) {
						header( "Location: directOrder.php?action=orderInfo&".$_POST['id']."&status=error" );
					} else {
						header( "Location: directOrder.php?action=orderInfoManager&".$_POST['id']."&status=error" );
					}
					
				} else {
					if($_SESSION['login']['group_id'] == 1) {
						header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=agreementIdSuccess" );	
					} else {
						header( "Location: directOrder.php?action=orderInfoManager&id=".$_POST['id']."&status=agreementIdSuccess" );	
					}
				}
			}	
		} else {
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: directOrder.php?action=orderInfoManager&".$_POST['id']."&status=agreementIdExist" );
			} else {
				header( "Location: directOrder.php?action=orderInfo&".$_POST['id']."&status=agreementIdExist" );
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
			header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=error" );
		} else {
			header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=descSubmitSuccess" );	
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
				header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=error" );
			} else {
				header( "Location: directOrder.php?action=orderInfoManager&id=".$_POST['id']."&status=error" );
			}
		} else {
			if($_SESSION['login']['group_id'] == 1) {
				header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=paymentChangeSuccess" );
			} else {
				header( "Location: directOrder.php?action=orderInfoManager&id=".$_POST['id']."&status=paymentChangeSuccess" );	
			}	
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
				header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=error" );
			} else {
				header( "Location: directOrder.php?action=orderInfoManager&id=".$_POST['id']."&status=error" );
			}
		} else {
			$status_response = $order->changeStatus($_POST['id'], 4);
			if($status_response == 0) {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: directOrder.php?action=orderInfo&".$_POST['id']."&status=error" );
				} else {
					header( "Location: directOrder.php?action=orderInfoManager&".$_POST['id']."&status=error" );
				}
			} else {
				if($_SESSION['login']['group_id'] == 1) {
					header( "Location: directOrder.php?action=orderInfo&id=".$_POST['id']."&status=paymentSubmitSuccess" );	
				} else {
					header( "Location: directOrder.php?action=orderInfoManager&id=".$_POST['id']."&status=paymentSubmitSuccess" );	
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