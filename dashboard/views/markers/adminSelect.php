<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php">Зурган тэмдэглэгээ</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php?action=adminSelect">
			Зурган тэмдэглэгээ нэмэх
		</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2>
				<i class="halflings-icon edit"></i><span class="break"></span><?php echo 'Зурган тэмдэглэгээ нэмэх'; ?>
			</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="markers.php?action=adminSelect" id="" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="MarkerType">Тэмдэглэгээний төрөл</label>
					<div class="controls">
						<select name="type_id" id="TypeId" required="required">
							<option value="">Сонгоно уу</option>
							<?php 
							$k = 0;
							foreach($types as $type) : 
								$k = $k + 1;
							?>
							<option value="<?php echo $type['id'] ?>"><?php echo $k.'. '.$type['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="MarkerType">Дүүрэг</label>
					<div class="controls">
						<select name="district_id" id="DistrictId" required="required">
							<option value="">Сонгоно уу</option>
							<?php foreach($districts as $dist) : ?>
							<option value="<?php echo $dist['id'] ?>"><?php echo $dist['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="selectType" class="btn btn-primary">Үргэлжлүүлэх</button>
			</div>
			</form>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>