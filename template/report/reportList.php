<?php
include(SITE_TEMPLATE. "header.php");
?>

<div id="pageReport">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="pageReportTitle">
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
									<option value="<?php echo $yr['year'] ?>"><?php echo $yr['year'].' он'; ?></option>
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
								<option value="<?php echo $district['id'] ?>"><?php echo $i.'. '.$district['title'].' дүүрэг'; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
							<div id="regionSelect" class="selectReportRow">						
							</div>
						</fieldset>
					</form>
				</div>
				<div class="col-md-8">
					<div id="reportList">
						
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