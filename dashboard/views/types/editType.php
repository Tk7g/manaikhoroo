<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/types.php">Индикаторын жагсаалт</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="#">Индикатор засварлах</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Индикатор засварлах</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="types.php?action=edit&id=<?php echo $current_type['id']; ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $current_type['id']; ?>" id="Id" />
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="Title">Индикаторын гарчиг</label>
					<div class="controls">
						<input type="text" name="title" id="Title" value="<?php echo $current_type['title']; ?>" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Title">Индикаторын харьяалагдах бүлэг</label>
					<div class="controls">
						<select name="group_type" id="GroupType">
							<option>Сонгоно уу</option>
							<?php foreach($group_types as $group_type) : ?>
							<option value="<?php echo $group_type['id']; ?>" <?php if($group_type['id'] == $current_type['group_type']){ echo 'selected'; } ?>><?php echo $group_type['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Image">Индикаторын зураг</label>
					<div class="controls">
						<input type="file" name="image" id="Image">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Image">Индикаторын одоогийн зураг</label>
					<img src="<?php echo $current_type['image']; ?>" />
				</div>
				<div class="control-group">
					<label class="control-label" for="Title">Эрэмбэ</label>
					<div class="controls">
						<input type="text" value="<?php echo $current_type['queue']; ?>" name="queue" id="Queue" required="required" class="input-xlarge"/>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="saveType" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>