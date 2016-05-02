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
			<form action="user.php?action=edit" id="" method="post">
			<fieldset>
				<input type="hidden" name="id" id="Id" value="<?php echo $current_user['id']; ?>" />
				<input type="hidden" name="group_id" id="GroupId" value="3" />
				<input type="hidden" name="district_id" id="GroupId" value="<?php echo $_SESSION['login']['district_id']; ?>" />
				<div class="control-group">
					<label class="control-label" for="Username">Хэрэглэгчийн нэр</label>
					<div class="controls">
						<input type="text" name="username" id="Username" value="<?php echo $current_user['username']; ?>" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Password">Нууц үг</label>
					<div class="controls">
						<input type="password" name="password" id="Password" required="required" value="<?php echo $current_user['password']; ?>" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="UserUsername">И-мэйл</label>
					<div class="controls">
						<input type="text" name="email" id="Email" required="required" value="<?php echo $current_user['email']; ?>" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="RegionId">Хороо</label>
					<div class="controls">
						<select name="region_id" id="RegionId" required="required">
							<option value="">Сонгоно уу</option>
							<?php foreach($regions as $rg) : ?>
								<option <?php if($current_user['region_id'] == $rg['id']) { echo 'selected'; } ?> value="<?php echo $rg['id']; ?>"><?php echo $rg['title'].'-р хороо'; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
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