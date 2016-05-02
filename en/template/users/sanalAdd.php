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
        			<div class="box-content status-message"><?php echo $result; ?></div>
				<?php } ?>
				<h2 class="up-title">
					Санал хүсэлт бичих
				</h2>
				<div class="sanalForm">
					<form action="user.php?page=write" id="sanalWrite" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="sanalType">Ангилал</label>
							<select class="form-control input-sm" required="required" name="sanaltype_id" id="SanalType">
								<option value="">- Сонгоно уу -</option>
								<?php
									$i = 0; 
									foreach($types as $type) : 
									$i = $i + 1;
								?>
								<option value="<?php echo $type['id'] ?>"><?php echo $i.'. '.$type['title']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="District">Дүүрэг</label>
							<select class="form-control input-sm" required="required" name="district_id" id="District">
								<option value="">- Сонгоно уу -</option>
								<?php 
									$i = 0; 
									foreach($districts as $district) : 
									$i = $i + 1; 
								?>
								<option value="<?php echo $district['id'] ?>"><?php echo $i.'. '.$district['title']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group" id="RegionSelect">
						</div>
						<div class="form-group">
							<label for="Content">Агуулга</label>
							<textarea class="form-control" name="content" id="Content" required="required" rows="10"></textarea>
						</div>
						<div class="form-group">
							<label for="File">Файл хавсаргах</label>
							<input type="file" name="file" id="fileToUpload">
						</div>
						<div class="form-group">
							<button type="submit" name="sendSanal" class="btn btn-primary">Илгээх</button>
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