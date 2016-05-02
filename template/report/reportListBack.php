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
	<option <?php if($_GET['region'] == $reg_list['id']) { echo 'selected'; } ?> value="<?php echo $reg_list['id'] ?>"><?php echo $reg_list['title'].'-р хороо'; ?></option>
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
		$region_title = Region::getRegion($_GET['region']);
?>

<div class="report-row">
	<!-- <div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=yearRegionReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>" target="_blank"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны тайлан (оны харьцуулалт)'; ?></a>
	</div> -->
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionProfileReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны нэгтгэсэн зураглал'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionBusReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны нийтийн тээвэр'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionHospitalReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны эрүүл мэнд'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionTrashReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны хог хаягдал'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionKinderReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны цэцэрлэг'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionSchoolReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны сургууль'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionGroundReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны нийтийн эзэмшлийн талбай'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionWellReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны усны хүртээмж'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionRiskReport&district=<?php echo $_GET['district'] ?>&region=<?php echo $_GET['region']; ?>&year=<?php echo $_GET['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_GET['year'].' оны аюултай бүс'; ?></a>
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