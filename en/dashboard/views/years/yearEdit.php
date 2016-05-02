<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/year.php">Оны жагсаалт</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/year.php?action=edit&id=<?php echo $current_year['id'] ?>">Он засварлах</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Он засварлах</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="year.php?action=edit&id=<?php echo $current_year['id']; ?>" method="post">
			<fieldset>
				<input type="hidden" name="id" value="<?php echo $current_year['id']; ?>" id="NewsId">
				<div class="control-group">
					<label class="control-label" for="title">Он</label>
					<div class="controls">
						<input type="text" name="year" id="yearYear" value="<?php echo $current_year['year']; ?>" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="yearUsed">Үндсэн он</label>
					<div class="controls">
						<select name="used" id="yearUsed" required="required">
							<option value="">Сонгоно уу</option>
							<option value="1" <?php if($current_year['used'] == 1) { echo 'selected'; }  ?>>Тийм</option>
							<option value="0" <?php if($current_year['used'] == 0) { echo 'selected'; }  ?>>Үгүй</option>
						</select>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="saveYear" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>