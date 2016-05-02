<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include("session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/">Хэрэглэгчийн жагсаалт</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/user.php">Нууц үг солих</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Нууц үг солих</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="user.php?action=passChange" id="" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="Password">Нууц үг</label>
					<div class="controls">
						<input type="password" name="password" id="Password" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group" id="UserDistrictSelectBox">
				</div>
				<div class="control-group" id="UserRegionSelectBox">	
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="passChange" class="btn btn-primary">Нууц үг солих</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>
<script>
$(document).ready(function () {
	$("#GroupId").bind("change", function (event) {$.ajax({async:true, data:$("#GroupId").serialize(), dataType:"html", success:function (data, textStatus) {$("#UserDistrictSelectBox").html(data);}, type:"post", url:"get_district.php"});
	return false;});
});
</script>