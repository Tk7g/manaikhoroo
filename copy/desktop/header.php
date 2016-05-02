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
	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/animate.min.css">

	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/style1.css">
	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/jquery.bxslider.css">
	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/datepicker/jquery-ui.css">
	 
	 <script src="<?php echo MAIN_FOLDER; ?>/js/vendor/modernizr.js"></script>
	 <script src="<?php echo MAIN_FOLDER; ?>/js/jquery-1.11.0.min.js"></script>
</head>
<body id="mainBody">

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=190384156235";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<div id="mainWrapper">
		<div id="mainHeader">
<div class="fixed">
<nav class="top-bar" data-topbar role="navigation">
  <section class="top-bar-section">
    <ul class="right">
    	<li><a href="<?php echo SITE_URL; ?>index.php">Нүүр хуудас</a></li>
    	<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=3">Бидний тухай</a></li>
    	<li class="has-dropdown">
    		<a href="#">Үйлчилгээ</a>
    		<ul class="dropdown">
				<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=4">Лаборатори</a></li>
				<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=5">Цемент</a></li>
				<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=6">Дайрга</a></li>
				<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=7">Элс</a></li>
				<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=13">Нэмэлт</a></li>
				<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=14">Тээвэрлэлт, техник хэрэгсэл</a></li>
				<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=15">Бетон цутгалтын үйлчилгээний авто бааз</a></li>
			</ul>
    	</li>
    	<li><a href="<?php echo SITE_URL; ?>news.php">Мэдээ</a></li>
    	<li><a href="<?php echo SITE_URL; ?>order.php">Захиалга</a></li>
    	<li><a href="<?php echo SITE_URL; ?>news.php?action=singleContent&id=17">Холбоо барих</a></li>
    	<li><img src="<?php echo MAIN_FOLDER; ?>/css/images/web/appstore.png" /></li>
    	<li><img src="<?php echo MAIN_FOLDER; ?>/css/images/web/android.png" /></li>
    </ul>
  </section>
</nav>
</div>
<div class="row">
	<div class="topLogo">
		<div class="large-5 large-centered columns">
			<img src="<?php echo MAIN_FOLDER; ?>/css/images/web-header.png">
		</div>
		</div>
	</div>
</div>