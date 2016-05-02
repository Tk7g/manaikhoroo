<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0, initial-scale=1.0, maximum-scale=2.0, user-scalable=no">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
	Удирдлагын хэсэг
	</title>
	<meta name="robots" content="index, nofollow">
	<meta name="google" content="translate" />
	<meta name="description" content="Хүннү Конкрет">
	<meta name="author" content="Гүрүтаг ХХК">
	<link href="<?php echo MAIN_FOLDER; ?>/favicon.ico" type="image/x-icon" rel="icon">
	<link href="<?php echo MAIN_FOLDER; ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">
	<link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/normalize.css">

	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/foundation.css">

	 <link rel="stylesheet" href="<?php echo MAIN_FOLDER; ?>/css/template1.css">
	 
	 <script src="<?php echo MAIN_FOLDER; ?>/js/vendor/modernizr.js"></script>
	 <script src="<?php echo MAIN_FOLDER; ?>/js/jquery-1.11.0.min.js"></script>
</head>
<body id="loginWrapper">
	<div class="row">
		<div class="large-6 large-centered columns">
			<div id="login-header">
				<img src="<?php echo MAIN_FOLDER; ?>/css/images/header.png"/>
			</div>	
		</div>
	</div>
	<div id="loginBox">
		<div class="row">
			<div class="large-4 large-centered columns">
				<div id="mainLoginBox">
					<form action="index.php?action=login" method="post">
						<div class="row">
							<div class="large-12 large-centered columns">
								<label>
									<input name="username" type="text" id="Username" required="required" placeholder="Нэвтрэх нэр" />
								</label>
							</div>
							<div class="large-12 large-centered columns">
								<label>
									<input name="password" type="password" id="Password" required="required" placeholder="Нууц үг">
								</label>
							</div>
							<div class="large-12 large-centered columns">
								<div class="login-btn text-center">
									<button type="submit" name="userLogin" class="button tiny expand secondary">Нэвтрэх</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>