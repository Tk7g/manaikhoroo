<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require(realpath(dirname(__FILE__))."/../classes/User.class.php");
require(realpath(dirname(__FILE__))."/../classes/Type.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'add':
		add();
		break;
	case 'edit':
		edit();
		break;
	case 'delete':
		delete();
		break;
	default:
		typeList();
}

function delete() {
	User::allowExecute(1);
	$type_id = Type::deleteType($_GET['id']);
	if($type_id == 0) {
		header( "Location: types.php?status=deleteUnsuccess" );
	} else {
		header( "Location: types.php?status=deleteSuccess" );	
	}
}

function edit() {
	User::allowExecute(1);
	$current_type = Type::getType($_GET['id']);
	if (isset($_POST['saveType'])) {
		$menu = new Type;
		$menu->editType($_POST, $_FILES);
		header( "Location: types.php?status=typeSaved" );
	}
	$group_types = Type::getGroupTypeList();
	require( ADMIN_TEMPLATE . "types/editType.php" );
}

function add() {
	User::allowExecute(1);
	if (isset($_POST['saveType'])) {
		$menu = new Type;
		$type_id = $menu->addType($_POST, $_FILES);
		if($type_id == FALSE) {
			header( "Location: types.php?status=unsuccess" );
		} else {
			header( "Location: types.php?status=typeSaved" );	
		}
	}
	$group_types = Type::getGroupTypeList();
	require( ADMIN_TEMPLATE . "types/typeAdd.php" );
}

function typeList() {
	User::allowExecute(1);
	$types = Type::getTypeList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "typeSaved" ) $results['statusMessage'] = "Зурган тэмдэглэгээ амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unsuccess" ) $results['statusMessage'] = "Хадгалах явцад алдаа гарсан тул дахин оролдоно уу.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Индикатор амжилттай устгагдлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['statusMessage'] = "Устгах явцад алдаа гарсан тул дахин оролдоно уу.";
  	}
	require( ADMIN_TEMPLATE . "types/typeList.php" );
}

function getGroupTypeName($typeid) {
	$type_name = Type::getGroupType($typeid);
	return $type_name['title'];
}

?>