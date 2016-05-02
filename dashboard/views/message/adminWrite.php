<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE. "session_check.php"); ?>

<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=districtList">Мессеж</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=districtWrite">Мессеж илгээх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Мессеж илгээх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="message.php?action=adminWrite" method="post">
			<input type="hidden" name="wrote" id="Wrote" value="<?php echo $_SESSION['login']['id']; ?>"/>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="title">Текст</label>
					<div class="controls">
						<textarea cols="50" rows="6" name="text" id="Text" required="required" class="input-xlarge"></textarea>
					</div>
				</div>
				<div class="control-group">
					<div class="userGroupTitle">
								<input type="checkbox" name="checkAllDistricts" id="CheckAllDistricts" onclick="checkAllDistrict();"> Дүүргүүдийн хэрэглэгчдийн жагсаалт
							</div>
							<div class="userDistrictRegionRow">
								<?php foreach($districts as $dist) : ?>
								<div class="userDistrictBlock">
									<input type="checkbox" name="district<?php echo $dist['id']; ?>" value="<?php echo $dist['id']; ?>" class="userDistrictCheck" id="DistrictCheck<?php echo $dist['id']; ?>">
									<label><?php echo $dist['title'].' дүүрэг'; ?></label>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="userGroupTitle"><input type="checkbox" name="checkAllRegions" id="CheckAllRegions" onclick="checkAllRegion();"> Хороодын хэрэглэгчдийн жагсаалт</div>
							<?php
							foreach($districts as $dist) :
								$district_regions = Region::getRegionList($dist['id']);
							?>
							<div class="userDistrictTitle">
								<input type="checkbox" name="checkAllRegions" class="checkAllRegs" id="CheckAllRegs<?php echo $dist['id']; ?>" onclick="checkAllReg(<?php echo $dist['id']; ?>);"> <?php echo $dist['title'].' дүүргийн хороодын хэрэглэгчид'; ?>
							</div>
							<div class="userDistrictRegionRow">
							<?php foreach($district_regions as $district_region) : ?>
								<?php if($district_region['id'] != $_SESSION['login']['region_id']) : ?>
								<div class="userDistrictRegionBlock">
									<input type="checkbox" name="region<?php echo $district_region['id']; ?>" value="<?php echo $district_region['id']; ?>" class="userDistrictRegionCheck regionCheck<?php echo $dist['id']; ?>" id="DistrictRegionCheck<?php echo $district_region['id']; ?>">
									<label><?php echo $district_region['title'].'-р хороо'; ?></label>	
								</div>
								<?php endif; ?>
							<?php endforeach; ?>
							</div> 
							<?php endforeach; ?>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" name="sendMessage" class="btn btn-primary">Илгээх</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script>

function checkAllDistrict() {
	if($('#CheckAllDistricts').is(':checked')) {
		$(".userDistrictCheck").prop('checked', true);
	} else {
		$(".userDistrictCheck").prop('checked', false);
	}
}

function checkAllRegion() {
	if($('#CheckAllRegions').is(':checked')) {
		$(".userDistrictRegionCheck").prop('checked', true);
	} else {
		$(".userDistrictRegionCheck").prop('checked', false);
	}
}

function checkAllReg(district) {
	if($('#CheckAllRegs'+district).is(':checked')) {
		$(".regionCheck"+district).prop('checked', true);
	} else {
		$(".regionCheck"+district).prop('checked', false);
	}
}

</script>

<?php include(MAIN_TEMPLATE. "footer2.php"); ?>