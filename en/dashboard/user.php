<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require(realpath(dirname(__FILE__))."/../classes/User.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'edit' :
		edit();
		break;
	case 'add':
    	add();
    	break;
	case 'delete':
		delete();
		break;
	case 'passChange':
		passChange();
		break;
	default:
		userList();
}

function passChange() {
	User::allowExecute(array(1,2,3));
	if (isset($_POST['passChange'])) {
		$user = new User;
		$user_id = $user->passwordChange($_SESSION['login']['username'], $_POST);
		if($user_id == 0) {
			header( "Location: index.php?action=home&status=passUn" );
		} else {
			header( "Location: index.php?action=home&status=passSuccess" );	
		}
	}
	require(ADMIN_TEMPLATE . "passChange.php");
}

function userList() {
if($_SESSION['login']['group_id'] == 1) {
	$results = array();
	$data = User::getUserList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "userSaved" ) $results['statusMessage'] = "Хэрэглэгч амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "userExist" ) $results['statusMessage'] = "Таны оруулсан нэртэй хэрэглэгч бүртгэгдсэн байна.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Хэрэглэгч амжилттай устгагдлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['statusMessage'] = "Устгах явцад алдаа гарсан тул дахин оролдоно уу.";
  	}
	require( ADMIN_TEMPLATE . "userList.php" );
} else {
	header("Location: index.php");	
}
}

function add() {
if($_SESSION['login']['group_id'] == 1) {
	if (isset($_POST['saveUser'])) {
		$user = new User;
		$user_id = $user->addUser($_POST);
		if($user_id == 0) {
			header( "Location: user.php?status=userExist" );
		} else {
			header( "Location: user.php?status=userSaved" );	
		}
	}
	require(ADMIN_TEMPLATE . "userAdd.php");
} else {
	header("Location: index.php");	
}
}

function edit() {
if($_SESSION['login']['group_id'] == 1) {
	$current_user = User::getUserInfo((int)$_GET['id']);
	if(isset($_POST['saveUser'])) {
		$user_id = User::editUser($_POST);
		if($user_id == 0) {
			header( "Location: user.php?status=userExist" );
		} else {
			header( "Location: user.php?status=userSaved" );	
		}
	}
	require(ADMIN_TEMPLATE . "userEdit.php");
} else {
	header("Location: index.php");	
}
}

function delete() {
if($_SESSION['login']['group_id'] == 1) {
	$current_user = User::getUserInfo((int)$_GET['id']);
	$user_id = User::deleteUser($current_user['id']);
	if($user_id == 0) {
		header( "Location: user.php?status=deleteUnsuccess" );
	} else {
		header( "Location: user.php?status=deleteSuccess" );	
	}
} else {
	header("Location: index.php");	
}
}
?>