<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require(realpath(dirname(__FILE__))."/../classes/User.class.php");
require(realpath(dirname(__FILE__))."/../classes/Menu.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'add':
		add();
		break;
	case 'delete':
		delete();
		break;
	default:
		menuList();
}

function delete() {
	User::allowExecute(1);
	$menu_id = Menu::deleteMenu($_GET['id']);
	if($menu_id == 0) {
		header( "Location: menu.php?status=deleteUnsuccess" );
	} else {
		header( "Location: menu.php?status=deleteSuccess" );	
	}
}

function add() {
	User::allowExecute(1);
	$components = array(
		1 => 'Нүүр хуудас',
		2 => 'Нийслэлийн газрын зураг',
		3 => 'Дүүргийн газрын зураг',
		4 => 'Тайлангийн хэсэг',
		5 => 'Мэдээллийн жагсаалт',
		6 => 'Мэдээний хуудас',
		7 => 'Саналын хэсэг',
		8 => 'Нэвтрэх хэсэг'
	);
	$parents = Menu::getParents();
	if (isset($_POST['saveMenu'])) {
		$menu = new Menu;
		$menu_id = $menu->addMenu($_POST, $_FILES);
		if($menu_id == FALSE) {
			header( "Location: menu.php?status=unsuccess" );
		} else {
			header( "Location: menu.php?status=menuSaved" );	
		}
	}
	require( ADMIN_TEMPLATE . "menus/menuAdd.php" );
}

function menuList() {
	User::allowExecute(1);
	$menus = Menu::getMenuList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "menuSaved" ) $results['statusMessage'] = "Цэс амжилттай хадгалагдлаа.";
    	if ( $_GET['status'] == "unsuccess" ) $results['statusMessage'] = "Хадгалах явцад алдаа гарсан тул дахин оролдоно уу.";
    	if ( $_GET['status'] == "deleteSuccess" ) $results['statusMessage'] = "Цэс амжилттай устгагдлаа.";
    	if ( $_GET['status'] == "deleteUnsuccess" ) $results['statusMessage'] = "Устгах явцад алдаа гарсан тул дахин оролдоно уу.";
  	}
	require( ADMIN_TEMPLATE . "menus/menuList.php" );
}

?>