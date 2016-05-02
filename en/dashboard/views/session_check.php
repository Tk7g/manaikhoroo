<?php
if (!isset($_SESSION['login'])) {
	header( "Location: index.php" );
} else {
	$now = time();
	if($now > $_SESSION['expire']) {
		unset($_SESSION);
		setcookie('login', '', time() - 86400);
		session_destroy();
		session_regenerate_id(true);
		header("Location: index.php");
	}
}
?>