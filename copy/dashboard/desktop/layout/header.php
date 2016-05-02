<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0, initial-scale=1.0, maximum-scale=2.0, user-scalable=no">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
	<?php
		if(isset($page_title)) {
			echo $page_title;
		} else {
			echo 'Hunnu Concrete';
		}
	?>
	</title>
	<meta name="robots" content="index, nofollow">
	<meta name="google" content="translate" />
	<meta name="description" content="Хүннү Конкрет">
	<meta name="keywords" content="Хүннү, бетон">
	<meta name="author" content="Гүрүтаг ХХК">
	<link href="<?php echo ROOT_FOLDER; ?>/favicon.ico" type="image/x-icon" rel="icon">
	<link href="<?php echo ROOT_FOLDER; ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">
	
	<link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/normalize.css">

	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/foundation.css">

	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/template1.css">
	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/font-awesome.min.css">
	  <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/datepicker/jquery-ui.css">
	 
	 <script src="<?php echo MAIN_FOLDER; ?>/js/vendor/modernizr.js"></script>
	 <script src="<?php echo MAIN_FOLDER; ?>/js/jquery-1.11.0.min.js"></script>
	 <script src="<?php echo MAIN_FOLDER; ?>/ckeditor/ckeditor.js"></script>
	 <script src="<?php echo MAIN_FOLDER; ?>/js/Chart.js"></script>
</head>
<body id="adminMain">
	<div id="topHeader">
		<div class="row fullWidth">
			<div class="medium-9 columns">
				<div class="logoTop">
					<img src="<?php echo MAIN_FOLDER.'/css/images/admin/logo-admin.png'; ?>" />
				</div>
			</div>
			<div class="medium-3 columns">
				<div class="logOutBtn">
					<a href="index.php?action=logout">Системээс Гарах</a>
				</div>
			</div>
		</div>
	</div>
	<div id="mainBody">
		<div class="row fullWidth">
			<div class="medium-2 columns menuLeft">
				<?php include(ADMIN_WEB_TEMPLATE. "layout/left-menu.php"); ?>
			</div>
			<div class="medium-10 columns mainWindow">