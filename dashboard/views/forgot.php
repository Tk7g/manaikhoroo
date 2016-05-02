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
			Нууц үг илгээх
		</div>
		<?php if ( isset( $result ) ) { ?>
        	<div class="box-content status-message"><?php echo $result; ?></div>
		<?php } ?>
		<div class="login-input">
			<form action="index.php?action=forgot" id="RegisterUser" method="post">
			<div class="form-group">
				<div class="login-label">И-мэйл хаягаа оруулна уу</div>
				<input type="text" name="email" id="Email" required="required" class="form-control"/>
			</div>
			<div class="login-btn">
				<button type="submit" name="userForgot" class="btn btn-primary">Илгээх</button>
			</div>
			<div class="backHome">
				<a class="btn btn-danger" href="http://manaikhoroo.ub.gov.mn">Нүүр хуудас руу буцах</a>
			</div>
			</form>
		</div>
	</div>
</body>
</html>