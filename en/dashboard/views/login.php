<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Манай хороо
	</title>
	<link href="<?php echo ROOT_FOLDER; ?>/favicon.ico" type="image/x-icon" rel="icon">
	<link href="<?php echo ROOT_FOLDER; ?>/favicon.ico" type="image/x-icon" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_FOLDER; ?>/css/admin/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_FOLDER; ?>/css/admin.css">
</head>
<body id="login-wrapper">
	<div id="login-box">
		<div class="login-header">
			Нэвтрэх хэсэг
		</div>
		<?php if ( isset( $result ) ) { ?>
        	<div class="box-content status-message"><?php echo $result; ?></div>
		<?php } ?>
		<div class="login-input">
			<form action="index.php?action=login" method="post">
			<div class="form-group">
				<div class="login-label">Хэрэглэгчийн нэр</div>
				<input type="text" name="username" id="Username" required="required" class="form-control"/>
			</div>
			<div class="form-group">
				<div class="login-label">Нууц үг</div>
				<input type="password" name="password" id="Password" required="required" class="form-control"/>
			</div>
			<div class="login-btn">
				<button type="submit" name="userLogin" class="btn btn-primary">Нэвтрэх</button>
			</div>
			<div class="backHome">
				<a class="btn btn-danger" href="http://manaikhoroo.ub.gov.mn">Нүүр хуудас руу буцах</a>
			</div>
			</form>
		</div>
	</div>
</body>
</html>