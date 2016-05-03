<?php
	// include i18n class and initialize it
	$dir=__DIR__.'/../../classes/Classes/php-i18n/';
	require_once $dir.'i18n.class.php';
	$i18n = new i18n(__DIR__.'/../../config/lang/lang_{LANGUAGE}.ini', $dir.'langcache/');
	// Parameters: language file path, cache dir, default language (all optional)
	if(isset($_GET['lang'])){
		$_SESSION['lang']=$_GET['lang'];
	}
	// init object: load language files, parse them if not cached, and so on.
	$i18n->init();
	$activeDistrict=null;
	if(isset($_GET['district'])){
		$activeDistrict=$_GET['district'];
	}
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
</head>
<body class="viewport">
<div id="map-container">
	<div id="map-box">
		<div id="map-marker-box">
			<div id="side-menu">
				<?php include('side-menu.php');?>
			</div>
			<div id="filter-panel" class="filter active">
				<span class="toggle-menu-filter glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<?php include('map-marker.php'); ?>
			</div>
		</div>

		<div id="map-district" class="map-control">
		</div>

		<div id="map-statistic">
			<?php 
			if($activeDistrict===null)
				include 'statistic.php';
			else
				include 'region-statistic.php';
			?>
		</div>
		<div id="map-switch" class="btn-group btn-group-justified" role="group" aria-label="...">
		  <div class="btn-group" role="group"><button type="button" class="btn btn-default" onclick="switchToMap()">Map</button></div>
		  <div class="btn-group" role="group"><button type="button" class="btn btn-default" onclick="switchToStat()">Statistic</button></div>
		</div>
		<span class="toggle-menu-filter glyphicon glyphicon-menu-hamburger map-control" aria-hidden="true"></span>

		<div id="district-menu" class="dropdown map-control">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    <?php if($activeDistrict===null):?>
		    	Дүүргүүд
		    <?php else:?>
		    	<?php echo $results['districts'][$activeDistrict-1]['title'];?>
		    <?php endif;?>
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
		  		<?php if($activeDistrict!==null):?>
		    	<li><a href="indicator.php">Дүүргүүд</a></li>
		    	<?php endif;?>
		    <?php foreach($results['districts'] as $district) : ?>

		    	<li>
					<a class="<?php echo $activeDistrict===$district['id']?'active':'';?>" href="indicator.php?action=regionView&district=<?php echo $district['id']; ?>"><?php echo $district['title']; ?></a>
				</li>
			<?php endforeach; ?>
		  </ul>
		</div>

		<div id="layer-menu" class="dropdown map-control">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    		    	дэвсгэр
		    		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

		    	<li>
						<a id="roadMapSelect">Замын зураглал</a>

				</li>

		    	<li>
						<a id="terrainSelect">Газар нутгийн нугачаа</a>
					</li>

		    	<li>
						<a id="hybridSelect">Холимог</a>
				</li>
				<li>
					<a id="osmSelect">OpenStreetMap</a>
			</li>
					  </ul>
		</div>

	</div>
	<div id="map-legend" class="map-control">
		<?php include 'district-select.php';?>
	</div>
</div>
<?php include 'district-script.php';?>
</body>
</html>
