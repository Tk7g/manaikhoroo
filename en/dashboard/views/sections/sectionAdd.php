<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/section.php">Хэсгийн хил</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>Хэсгийн хилийн нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="section.php?action=add" id="" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="MarkerType">Хэсгийн харьяалагдах дүүрэг</label>
					<div class="controls">
						<select name="district_id" id="DistrictId" required="required">
							<option value="">Сонгоно уу</option>
							<?php foreach($districts as $district) : ?>
							<option value="<?php echo $district['id'] ?>"><?php echo $district['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div id="regionSelect" class="control-group">
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="selectRegion" class="btn btn-primary">Үргэлжлүүлэх</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>
<script>
$(document).ready(function () {
	$("#DistrictId").bind("change", function (event) {$.ajax({async:true, data:$("#DistrictId").serialize(), dataType:"html", success:function (data, textStatus) {$("#regionSelect").html(data);}, type:"post", url:"get_regions.php"});
	return false;});
});
</script>