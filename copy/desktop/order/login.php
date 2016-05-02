<?php
include(WEB_TEMPLATE."header.php");
?>

<div id="homeWrapper">
	<div class="orderBlock">
		<div class="row">
			<div class="medium-6 medium-centered columns">
				<div class="orderSelect">
					<div class="row">
						<div class="medium-6 columns text-center">
							<div class="gereetOrder">
								<a class="orderTypeBtn" href="order.php">Гэрээт захиалга</a>
							</div>
						</div>
						<div class="medium-6 columns text-center">
							<div class="directOrder">
								<a class="orderTypeBtn" href="order.php?action=directOrder">Гэрээт бус захиалга</a>
							</div>	
						</div>
					</div>
				</div>
				<div class="orderLoginForm">
					<form action="order.php?action=login" method="post" autocomplete="off">
						<label>
							<input name="agreement_id" type="text" id="AgreementID" required="required" placeholder="Гэрээний №" />
						</label>
						<label>
							<input name="password" type="password" id="Password" required="required" placeholder="Нууц үг" />
						</label>
						<div class="loginBtn text-center">
							<button type="submit" name="userLogin" class="button expand">Нэвтрэх</button>
						</div>
					</form>
				</div>
				<div class="orderTermsBtn">
					<a href="#">Үйлчилгээний нөхцөл</a>
				</div>
				<div class="socialRow">
					<div class="row">
						<div class="medium-9 medium-centered columns">
							<div class="row">
								<div class="medium-3 columns">
									<a href="#"><img src="<?php echo IMG_FOLDER.'fb.png'; ?>" /></a>
								</div>
								<div class="medium-3 columns">
									<a href="#"><img src="<?php echo IMG_FOLDER.'twt.png'; ?>" /></a>
								</div>
								<div class="medium-3 columns">
									<a href="#"><img src="<?php echo IMG_FOLDER.'yt.png'; ?>" /></a>
								</div>
								<div class="medium-3 columns">
									<a href="#"><img src="<?php echo IMG_FOLDER.'ggl.png'; ?>" /></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include(WEB_TEMPLATE."footer.php");
?>