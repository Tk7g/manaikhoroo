<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0, initial-scale=1.0, maximum-scale=2.0, user-scalable=no">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Удирдлагын хэсэг</title>
	<meta name="robots" content="index, nofollow">
	<meta name="google" content="translate" />
	<meta name="description" content="Хүннү Конкрет">
	<meta name="author" content="Гүрүтаг ХХК">
	<link href="<?php echo ROOT_FOLDER; ?>/favicon.ico" type="image/x-icon" rel="icon">
	<link href="<?php echo ROOT_FOLDER; ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">
	
	<link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/normalize.css">

	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/foundation.css">

	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/template.css">
	 
	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/font-awesome.min.css">
	 
	 <script src="<?php echo MAIN_FOLDER; ?>/js/vendor/modernizr.js"></script>
	 <script src="<?php echo MAIN_FOLDER; ?>/js/jquery-1.11.0.min.js"></script>
</head>
<body id="wrapper-mobile">

<div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
    <nav class="tab-bar">
      <section class="left-small">
        <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
      </section>

      <section class="right tab-bar-section">
      		<?php echo $page_title; ?>
      </section>

    </nav>

    <aside class="left-off-canvas-menu">
      <ul class="off-canvas-list">
        <li><label>Үндсэн цэс</label></li>
        <?php if($_SESSION['login']['group_id'] == 1) { ?>
        <li><a href="company.php">Гэрээт компаниуд</a></li>
        <li><a href="order.php">Гэрээт захиалга</a></li>
        <li><a href="directOrder.php">Гэрээт бус захиалга</a></li>
        <li><a href="user.php">Системийн хэрэглэгчид</a></li>
        <?php } elseif($_SESSION['login']['group_id'] == 2) { ?>
        <li><a href="company.php">Гэрээт компаниуд</a></li>
        <li><a href="order.php?action=orderManager">Гэрээт захиалга</a></li>
        <li><a href="directOrder.php?action=orderManager">Гэрээт бус захиалга</a></li>
        <?php } else { ?>
        	<li><a href="order.php?action=orderFactory">Гэрээт захиалга</a></li>
        	<li><a href="directOrder.php?action=orderFactory">Гэрээт бус захиалга</a></li>
        <?php } ?>
        <li><a href="index.php?action=logout">Системээс гарах</a></li>
      </ul>
    </aside>

    <section class="main-section">
