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
			<h2 class="up-title">
				Газрын зургийн тэмдэглэгээ нэмэх
			</h2>
			<div class="markerAddComponent">
			<form action="user.php?page=select" id="typeSelect" method="post" enctype="multipart/form-data">
				<div class="add-row">
					<label>Тэмдэглэгээний төрөл</label>
					<select class="form-control input-sm" required="required" name="type_id" id="TypeSelect">
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
				<div class="add-row">
					<label>Дүүрэг</label>
					<select class="form-control input-sm" required="required" name="district_id" id="DistrictSelect">
						<option value="">- Сонгоно уу -</option>
						<?php
							$i = 0; 
							foreach($districts as $district) : 
							$i = $i + 1;
						?>
						<option value="<?php echo $district['id'] ?>"><?php echo $i.'. '.$district['title'].' дүүрэг'; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div id="regionSelect" class="add-row">
				</div>
				<div class="form-group">
					<button type="submit" name="selectType" class="btn btn-primary">Үргэлжлүүлэх</button>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function () {
	$("#DistrictSelect").bind("change", function (event) {$.ajax({async:true, data:$("#DistrictSelect").serialize(), dataType:"html", success:function (data, textStatus) {$("#regionSelect").html(data);}, type:"post", url:"getRegion.php"});
	return false;});
});
</script>
<?php include(SITE_TEMPLATE. "footer.php"); ?>