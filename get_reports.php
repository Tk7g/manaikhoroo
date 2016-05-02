<?php
	require(realpath(dirname(__FILE__))."/classes/Marker.class.php");
	require(realpath(dirname(__FILE__))."/classes/District.class.php");
	require(realpath(dirname(__FILE__))."/classes/Region.class.php");
	$year = $_POST['year'];
?>

<?php
	if($_POST['district_id'] == NULL) {
?>
	<div class="report-row">
		<div class="report-col">
		Дүүрэг сонгоно уу
		</div>
	</div>
<?php	
	} elseif($_POST['region_id'] == NULL) {
		$district_title = District::getDistrict($_POST['district_id']);
?>

<div class="report-row">
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=districtProfileReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$_POST['year'].' оны нэгтгэсэн зураглал'; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=districtBusReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$_POST['year'].' оны нийтийн тээвэр'; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=districtSchoolReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$_POST['year'].' оны сургууль'; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=districtKinderReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$_POST['year'].' оны цэцэрлэг'; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=districtHospitalReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$_POST['year'].' оны эрүүл мэнд'; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=districtTrashReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$_POST['year'].' оны хог хаягдал'; ?></a>
	</div>
</div>

<?php
	} else {
		$district_title = District::getDistrict($_POST['district_id']);
		$region_title = Region::getRegion($_POST['region_id']);
?>

<div class="report-row">
	<!-- <div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=yearRegionReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>" target="_blank"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны тайлан (оны харьцуулалт)'; ?></a>
	</div> -->
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionProfileReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны нэгтгэсэн зураглал'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionBusReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны нийтийн тээвэр'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionHospitalReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны эрүүл мэнд'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionTrashReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны хог хаягдал'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionKinderReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны цэцэрлэг'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionSchoolReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны сургууль'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionGroundReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны нийтийн эзэмшлийн талбай'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionWellReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны усны хүртээмж'; ?></a>
	</div>
	
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/report.php?action=regionRiskReport&district=<?php echo $_POST['district_id'] ?>&region=<?php echo $_POST['region_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo $district_title['title'].' дүүргийн '.$region_title['title'].'-р хорооны '.$_POST['year'].' оны аюултай бүс'; ?></a>
	</div>
	
</div>

<?php
	}
?>