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

	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/style.css">
	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/datepicker/jquery-ui.css">
	 
	 <script src="<?php echo MAIN_FOLDER; ?>/js/vendor/modernizr.js"></script>
	 <script src="<?php echo MAIN_FOLDER; ?>/js/jquery-1.11.0.min.js"></script>
</head>
<body id="wrapper2">

<div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
    <nav class="tab-bar">
      <section class="left-small">
        <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
      </section>

      <section class="middle tab-bar-section">
      <?php 
      if(isset($page_title)) {
	  	echo $page_title;
	  } else {
	  	echo 'Хүннү Констракшн';
	  }
      ?>
      </section>
    </nav>

    <aside class="left-off-canvas-menu">
      <ul class="off-canvas-list">
        <li><label>Үндсэн цэс</label></li>
        <li><a href="index.php">Нүүр хуудас</a></li>
        <li><a href="order.php">Гэрээт захиалга</a></li>
        <li><a href="order.php?action=directOrder">Гэрээт бус захиалга</a></li>
        <li><a href="news.php">Мэдээ, мэдээлэл</a></li>
        <li><a href="news.php?action=content&cat=2">GPS - хяналтын систем</a></li>
        <li><a href="news.php?action=singleContent&id=17">Холбоо барих</a></li>
        <?php if($_SESSION != NULL) { ?>
        <li><a href="order.php?action=myOrder">Миний захиалгууд</a></li>
        <li><a href="order.php?action=companyInfo">Компаний бүртгэл</a></li>
        <li><a href="order.php?action=logout">Системээс гарах</a></li>
        <?php } ?>
      </ul>
    </aside>

    <section class="main-section">
    
    