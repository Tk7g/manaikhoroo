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
			Дүүрэг сонгоно уу
		</div>
	</div>
<?php
	} else {
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
<?php } ?>