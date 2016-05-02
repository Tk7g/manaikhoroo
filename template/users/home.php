<?php 
include(ADMIN_TEMPLATE."session_check.php"); 
include(SITE_TEMPLATE. "header.php");
?>
<div id="userPage">
	<div class="container">
		<div class="col-md-2">
		<?php require(SITE_TEMPLATE . "users/menu-left.php"); ?>
		</div>
		<div class="col-md-10">
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