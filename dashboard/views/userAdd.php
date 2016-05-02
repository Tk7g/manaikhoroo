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
		<a href="/dashboard/user.php?action=add">Хэрэглэгч нэмэх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Хэрэглэгч нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="user.php?action=add" id="" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="Username">Хэрэглэгчийн нэр</label>
					<div class="controls">
						<input type="text" name="username" id="Username" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Password">Нууц үг</label>
					<div class="controls">
						<input type="password" name="password" id="Password" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="UserUsername">И-мэйл</label>
					<div class="controls">
						<input type="text" name="email" id="Email" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="UserGroup">Хэрэглэгчийн бүлэг</label>
					<div class="controls">
						<select name="group_id" id="GroupId" required="required">
							<option value="">Сонгоно уу</option>
							<option value="1">Администратор</option>
							<option value="2">Дүүргийн админ</option>
							<option value="3">Хорооны админ</option>
						</select>
					</div>
				</div>
				<div class="control-group" id="UserDistrictSelectBox">
				</div>
				<div class="control-group" id="UserRegionSelectBox">	
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="saveUser" class="btn btn-primary">Хадгалах</button>
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