<?php
	require(realpath(dirname(__FILE__))."/classes/Marker.class.php");
	require(realpath(dirname(__FILE__))."/classes/District.class.php");
	require(realpath(dirname(__FILE__))."/classes/Region.class.php");
	$types = Marker::getTypes();
	$years = Marker::getYears();
	if($_POST['district_id'] == NULL) {
?>
	<div class="report-row">
		<div class="report-col">
			Please select district
		</div>
	</div>
<?php
	} else {
	$district_title = District::getDistrict($_POST['district_id']);
?>

<div class="report-row">
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtProfileReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo 'General report of '.$district_title['title'].' district\'s of '.$_POST['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtBusReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo 'Bus report of '.$district_title['title'].' district\'s of '.$_POST['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtSchoolReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo 'School report of '.$district_title['title'].' district\'s of  '.$_POST['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtKinderReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo 'Kindergarten report of '.$district_title['title'].' district\'s of '.$_POST['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtHospitalReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo 'Health report of '.$district_title['title'].' district\'s of '.$_POST['year']; ?></a>
	</div>
	<div class="report-col">
		<a href="http://manaikhoroo.ub.gov.mn/en/report.php?action=districtTrashReport&district=<?php echo $_POST['district_id']; ?>&year=<?php echo $_POST['year']; ?>"><?php echo 'Trash report of '.$district_title['title'].' district\'s of '.$_POST['year']; ?></a>
	</div>
</div>
<?php } ?>