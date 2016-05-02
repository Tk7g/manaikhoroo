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
			<div class="user-component">
				<?php if ( isset( $result ) ) { ?>
        			<div class="box-content status-message"><?php print_r($result); ?></div>
				<?php } ?>
				<h2 class="up-title">
					Санал хүсэлт бичих
				</h2>
				<div class="sanalForm">
					<form action="user.php?page=passChange" id="passChange" method="post">
						<div class="form-group">
							<label for="Password">Нууц үг</label>
							<input type="password" name="password" id="Password" required="required" class="form-control"/>
						</div>
						<div class="form-group">
							<button type="submit" name="passChange" class="btn btn-primary">Илгээх</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function () {
	$("#District").bind("change", function (event) {$.ajax({async:true, data:$("#District").serialize(), dataType:"html", success:function (data, textStatus) {$("#RegionSelect").html(data);}, type:"post", url:"get_regions.php"});
	return false;});
});
</script>
<?php include(SITE_TEMPLATE. "footer.php"); ?>