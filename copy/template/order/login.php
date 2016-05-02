<?php
include(SITE_TEMPLATE."header.php");
?>

<div id="order-login-box">
	<div class="row">
		<div class="small-10 large-6 small-centered large-centered columns">
			<div class="login-header">
				<div class="row">
					<div class="small-6 large-6 columns text-center">
						<a class="gereet" href="order.php">Гэрээт</a>
					</div>
					<div class="small-6 large-6 columns text-center">
						<a class="gereet-bus" href="order.php?action=directOrder">Гэрээт бус</a>
					</div>
				</div>
			</div>
		</div>
	<form action="order.php?action=login" method="post" autocomplete="off">
		<div class="small-10 large-6 small-centered large-centered columns">
			<label>
				<input name="agreement_id" type="text" id="AgreementID" required="required" placeholder="Гэрээний №" />
			</label>
		</div>
		<div class="small-10 large-6 small-centered large-centered columns">
			<label>
				<input name="password" type="password" id="Password" required="required" placeholder="Нууц үг" />
			</label>
		</div>
		<div class="small-10 large-6 small-centered large-centered columns">
			<div class="login-btn text-center">
				<button type="submit" name="userLogin" class="button expand tiny secondary">Нэвтрэх</button>
			</div>
		</div>
	</div>
	</form>
</div>

<div class="row">
	<div class="small-10 large-6 small-centered large-centered columns text-center">
		<div class="term_conditions">
			<a href="#">Үйлчилгээний нөхцөл</a>
		</div>
	</div>
</div>

<?php include(SITE_TEMPLATE.'mobile/footer-social.php'); ?>

<?php
include(SITE_TEMPLATE."footer.php");
?>