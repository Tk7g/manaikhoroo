<?php include(SITE_TEMPLATE. "header.php"); ?>
<div id="userPage">
	<div class="container">
		<div class="row">
		<div class="col-md-4">
			<div class="details">
				Та манай системд бүртгүүлэхэд оруулсан и-мэйл хаягаа доорх нүдэнд оруулна уу. Ингэснээр бид таны и-мэйл хаяг руу таны шинэ нууц үг болон хэрэглэгчийн нэрийг илгээх болно.
			</div>
			<div class="register-form">
				<form action="user.php?page=forgot" id="RegisterUser" method="post">
					<div class="register-row">
						<label>И-мэйл</label>
						<input type="email" name="email" id="Email" required class="input-xlarge"/>
					</div>
					<div class="register-btn">
						<button type="submit" name="userForgot" class="btn btn-primary">Илгээх</button>
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