<?php
require(realpath(dirname(__FILE__))."/../config/settings.php");
require_once(realpath(dirname(__FILE__))."/../classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/../classes/Faq.class.php");

session_start();

$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
	case 'edit' :
		edit();
		break;
	default:
		faqList();
}

function edit() {
	User::allowExecute(array(1));
	$current_faq = Faq::getFaq((int)$_GET['id']);
	if(isset($_POST['saveFaq'])) {
		Faq::editFaq($_POST);
		header( "Location: faq.php?status=faqSaved" );
	}
	require(ADMIN_TEMPLATE . "faq/faqEdit.php");
}

function faqList() {
	User::allowExecute(array(1));
	$results = array();
	$data = Faq::getList();
	if ( isset( $_GET['status'] ) ) {
    	if ( $_GET['status'] == "faqSaved" ) $results['statusMessage'] = "Мэдээ амжилттай хадгалагдлаа.";
  	}
	require( ADMIN_TEMPLATE . "faq/faqList.php" );
}

?>