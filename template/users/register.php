<?php include(SITE_TEMPLATE. "header.php"); ?>
<div id="userPage">
	<div class="container">
		<div class="row">
		<div class="col-md-4">
			<div class="register-form">
				<form action="user.php?page=register" id="RegisterUser" method="post">
					<div class="register-row">
						<label>Хэрэглэгчийн нэр</label>
						<input type="text" name="username" id="Username" required="required" pattern=".{3,50}" class="input-xlarge"/>
					</div>
					<div class="register-row">
						<label>И-мэйл</label>
						<input type="email" name="email" id="Email" required class="input-xlarge"/>
					</div>
					<div class="register-row">
						<label>Овог</label>
						<input type="text" name="lastname" id="Lastname" required="required" pattern=".{3,50}" class="input-xlarge"/>
					</div>
					<div class="register-row">
						<label>Нэр</label>
						<input type="text" name="firstname" id="Firstname" required="required" pattern=".{3,50}" class="input-xlarge"/>
					</div>
					<div class="register-row">
						<label>Регистрийн дугаар</label>
						<input type="text" name="identity" id="Identity" required="required" class="input-xlarge" pattern="^[\u0400-\u04FF]{2}[0-9]{8}"/>
					</div>
					<div class="register-row">
						<label>Утасны дугаар</label>
						<input type="text" name="phone" pattern=".{6,50}" id="Phone" required="required" class="input-xlarge"/>
					</div>
					<div class="register-btn">
						<button type="submit" name="userRegister" class="btn btn-primary">Бүртгүүлэх</button>
					</div>
				</form>
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
</div>
<?php include(SITE_TEMPLATE. "footer.php"); ?>