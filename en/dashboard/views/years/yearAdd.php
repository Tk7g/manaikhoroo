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
		<a href="/dashboard/year.php?action=add">Он нэмэх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Он нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="year.php?action=add" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="title">Он</label>
					<div class="controls">
						<input type="text" name="year" id="yearYear" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="yearUsed">Үндсэн он</label>
					<div class="controls">
						<select name="used" id="yearUsed" required="required">
							<option value="">Сонгоно уу</option>
							<option value="1">Тийм</option>
							<option value="0">Үгүй</option>
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