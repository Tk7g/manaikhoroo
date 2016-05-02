<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/section.php?action=regionSelect">Хэсгийн хил</a>
		<i class="icon-angle-right"></i>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2>
				<i class="halflings-icon edit"></i><span class="break"></span><?php echo $district['title'].' дүүргийн хэсгийн хил'; ?>
			</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<video width="300" height="147" controls>
  				<source src="<?php echo MAIN_FOLDER.'/video/district/dheseg.mp4'; ?>" type="video/mp4">
  				<source src="<?php echo MAIN_FOLDER.'/video/district/dheseg.ogg'; ?>" type="video/ogg">
  				Your browser does not support HTML5 video.
			</video>
		</div>
		<div class="box-content">
			<form action="section.php?action=regionSelect" id="" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="RegionId">Хороо</label>
					<div class="controls">
						<select name="region_id" id="RegionId" required="required">
							<option value="">Сонгоно уу</option>
							<?php foreach($regions as $reg) : ?>
							<option value="<?php echo $reg['id'] ?>"><?php echo $reg['title']; ?>-р хороо</option>
							<?php endforeach; ?>
						</select>
					</div>
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