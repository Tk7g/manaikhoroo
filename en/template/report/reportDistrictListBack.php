<?php
include(SITE_TEMPLATE. "header.php");
?>

<div id="pageReport">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="pageTitle">
					Тайлан
				</div>
				<div class="reportComponent">
				<div class="col-md-4">
					<form action="report.php" id="reportSelect" method="post">
						<fieldset>
							<div class="selectReportRow">
								<label>Он</label>
								<select class="form-control" required="required" name="year" id="yearSelect">
								<?php 
									foreach($years as $yr) : 
								?>
									<option <?php if($_GET['year'] == $yr['year']) { echo 'selected'; } ?> value="<?php echo $yr['year'] ?>"><?php echo $yr['year'].' он'; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
							<div class="selectReportRow">
								<label>Дүүрэг</label>
								<select class="form-control" required="required" name="district_id" id="DistrictSelect">
								<option value="">- Сонгоно уу -</option>
								<?php
									$i = 0; 
									foreach($districts as $district) : 
									$i = $i + 1;
								?>
								<option <?php if($_GET['district'] == $district['id']) { echo 'selected'; } ?> value="<?php echo $district['id'] ?>"><?php echo $i.'. '.$district['title'].' дүүрэг'; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
							<div id="regionSelect" class="selectReportRow">
<label for="Region">Хороо</label>
<select class="form-control input-sm" required="required" name="region_id" id="Region">
	<option value="">- Сонгоно уу -</option>
	<?php
		$i = 0;
		foreach($region_list as $reg_list) :
		$i = $i + 1;
	?>
	<option value="<?php echo $reg_list['id'] ?>"><?php echo $reg_list['title'].'-р хороо'; ?></option>
	<?php endforeach; ?>
</select>
<script>
$(document).ready(function () {
	$("#Region").bind("change", function (event) {$.ajax({async:true, data:$("#reportSelect").serialize(), dataType:"html", success:function (data, textStatus) {$("#reportList").html(data);}, type:"post", url:"get_reports.php"});
	return false;});
});
</script>
							
							</div>
						</fieldset>
					</form>
				</div>
				<div class="col-md-8">
					<div id="reportList">
						
<?php
	$year = $_GET['year'];
?>

<?php	
		$district_title = District::getDistrict($_GET['district']);
?>

<div class="report-row">
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtProfileReport&district=<?php echo $_GET['district']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo 'General report of '.$district_title['title'].' district\'s of '.$_GET['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtBusReport&district=<?php echo $_GET['district']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo 'Bus report of '.$district_title['title'].' district\'s of '.$_GET['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtSchoolReport&district=<?php echo $_GET['district']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo 'School report of '.$district_title['title'].' district\'s of  '.$_GET['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtKinderReport&district=<?php echo $_GET['district']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo 'Kindergarten report of '.$district_title['title'].' district\'s of '.$_GET['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtHospitalReport&district=<?php echo $_GET['district']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo 'Health report of '.$district_title['title'].' district\'s of '.$_GET['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtTrashReport&district=<?php echo $_GET['district']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo 'Trash report of '.$district_title['title'].' district\'s of '.$_GET['year']; ?></a>
	</div>
</div>
						
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include(SITE_TEMPLATE. "footer.php");
?>
<script>
$(document).ready(function () {
	$("#DistrictSelect").bind("change", function (event) {$.ajax({async:true, data:$("#DistrictSelect").serialize(), dataType:"html", success:function (data, textStatus) {$("#regionSelect").html(data);}, type:"post", url:"get_regions.php"});
	return false;});
});

$(document).ready(function () {
	$("#DistrictSelect").bind("change", function (event) {$.ajax({async:true, data:$("#reportSelect").serialize(), dataType:"html", success:function (data, textStatus) {$("#reportList").html(data);}, type:"post", url:"get_districtReports.php"});
	return false;});
});

$(document).ready(function () {
	$("#yearSelect").bind("change", function (event) {$.ajax({async:true, data:$("#reportSelect").serialize(), dataType:"html", success:function (data, textStatus) {$("#reportList").html(data);}, type:"post", url:"get_reports.php"});
	return false;});
});

</script>