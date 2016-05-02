<?php include(SITE_TEMPLATE. "header.php"); ?>
<div id="userPage">
	<div class="container">
		<div class="col-md-4">
			<div class="login-box"> 
				<div class="login-header">
					Нэвтрэх хэсэг
				</div>
				<?php if ( isset( $result ) ) { ?>
        			<div class="box-content status-message"><?php echo $result; ?></div>
				<?php } ?>
				<div class="login-detail">
					<form action="user.php?action=login" method="post">
						<div class="login-input">
							<div class="login-label">И-мэйл</div>
							<input type="text" name="email" id="Username" required="required" class="form-control"/>
						</div>
						<div class="login-input">
							<div class="login-label">Нууц үг</div>
							<input type="password" name="password" id="Password" required="required" class="form-control"/>
						</div>
						<div class="login-btn">
							<button type="submit" name="userLogin" class="loginBtn">Нэвтрэх</button>
						</div>
					</form>
				</div>
				<div class="registerBtn">
					<a href="user.php?page=register">Бүртгүүлэх</a>
				</div>
				<div class="forgotPass">
					Хэрэглэгчийн нэр эсвэл нууц үг мартсан тохиолдолд <a href="user.php?page=forgot">энд дарна уу</a>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="faq-box">
				<div class="faq-title">
					<?php echo $faq['title']; ?>
				</div>
				<div class="faq-content">
					<?php echo $faq['content']; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include(SITE_TEMPLATE. "footer.php"); ?>