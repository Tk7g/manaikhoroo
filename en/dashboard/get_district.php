<?php
require(realpath(dirname(__FILE__))."/../classes/District.class.php");

if($_POST['group_id'] == 1) {
?>
<script>
$(document).ready(function () {
  	$("#RegionIdLabel").remove();
  	$("#RegionId").remove();
});
</script>
<?php
} else {
	$districts = District::getDistrictList();
?>
<label class="control-label" for="DistrictId">Харьяалагдах дүүрэг</label>
<div class="controls">
	<select name="district_id" id="DistrictId" required="required">
		<option value="">Сонгоно уу</option>
		<?php foreach($districts as $district) : ?>
		<option value="<?php echo $district['id']; ?>"><?php echo $district['title']; ?></option>
		<?php endforeach; ?>
	</select>
</div>
<div class="script-block">
<script>
$(document).ready(function () {
  	$("#RegionIdLabel").remove();
  	$("#RegionId").remove();
});
</script>
</div>
<?php
}
if($_POST['group_id'] == 3) {
?>
<div class="script-block">
<script>
$(document).ready(function () {
	$("#DistrictId").bind("change", function (event) {$.ajax({async:true, data:$("#DistrictId").serialize(), dataType:"html", success:function (data, textStatus) {$("#UserRegionSelectBox").html(data);}, type:"post", url:"get_region.php"});
	return false;});
});
$(document).ready(function () {
  	$("#UserRegionSelectLabel").remove();
  	$("#UserRegionSelect").remove();
});
</script>
</div>
<?php } ?>