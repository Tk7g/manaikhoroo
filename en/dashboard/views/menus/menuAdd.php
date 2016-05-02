<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/menu.php">Цэсний жагсаалт</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/menu.php?action=add">Цэс нэмэх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Цэс нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="menu.php?action=add" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="Title">Цэсний гарчиг</label>
					<div class="controls">
						<input type="text" name="title" id="Title" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Sub">Дэд цэс</label>
					<div class="controls">
						<select name="sub" id="Sub">
							<option value="">Эх цэс</option>
							<?php foreach($parents as $parent) : ?>
							<option value="<?php echo $parent['id'] ?>"><?php echo $parent['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Component">Төрөл</label>
					<div class="controls">
						<select name="component" id="Component" required="required">
							<option value="">Сонгоно уу</option>
							<?php foreach($components as $k => $v) : ?>
							<option value="<?php echo $k ?>"><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div id="menuAdditional">
				</div>
				<div class="control-group">
					<label class="control-label" for="Image">Цэсний зураг</label>
					<div class="controls">
						<input type="file" name="image" id="Image">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Title">Эрэмбэ</label>
					<div class="controls">
						<input type="text" name="queue" id="Queue" required="required" class="input-xlarge"/>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="saveMenu" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
$(document).ready(function () {
	$("#Component").bind("change", function (event) {$.ajax({async:true, data:$("#Component").serialize(), dataType:"html", success:function (data, textStatus) {$("#menuAdditional").html(data);}, type:"post", url:"menuAdditional.php"});
	return false;});
});
</script>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>