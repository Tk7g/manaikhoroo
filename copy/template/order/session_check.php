<?php
if (!isset($_SESSION['company'])) {
	header( "Location: order.php" );
} else {
	$now = time();
	if($now > $_SESSION['company_expire']) {
		unset($_SESSION);
		setcookie('login', '', time() - 86400);
		session_destroy();
		session_regenerate_id(true);
		header("Location: order.php");
	}
}
?>