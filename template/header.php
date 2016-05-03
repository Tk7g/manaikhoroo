<?php
	// include i18n class and initialize it
	$dir=__DIR__.'/../classes/Classes/php-i18n/';
	require_once $dir.'i18n.class.php';
	$i18n = new i18n(__DIR__.'/../config/lang/lang_{LANGUAGE}.ini', $dir.'langcache/');
	// Parameters: language file path, cache dir, default language (all optional)
	if(isset($_GET['lang'])){
		$_SESSION['lang']=$_GET['lang'];
	}
	// init object: load language files, parse them if not cached, and so on.
	$i18n->init();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>
		<?php echo L::title; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="robots" content="index, nofollow">
	<meta name="google" content="translate" />
	<meta name="description" content="Улаанбаатар хотын зураглал">
	<meta name="keywords" content="хороо, дүүрэг, улаанбаатар, газрын зураг, зураг, зураглал, статистик, мэдээлэл">
	<meta name="author" content="Нийслэлийн мэдээлэл, технологийн газар">
	<link href="<?php echo ROOT_FOLDER; ?>/favicon.png" type="image/x-icon" rel="icon">
	<link href="<?php echo ROOT_FOLDER; ?>/favicon.png" type="image/x-icon" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_FOLDER; ?>/css/template.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_FOLDER; ?>/css/bs/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_FOLDER; ?>/css/chosen.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_FOLDER; ?>/css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_FOLDER; ?>/css/font-awesome.min.css">
	<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/bs/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/Chart.min.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chosen.jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">

	<?php include('mainmenu.php'); ?>
	
	<div id="main-wrapper">