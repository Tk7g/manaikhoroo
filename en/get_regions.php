<?php 
	require(realpath(dirname(__FILE__))."/classes/Region.class.php"); 
	$regions = Region::getRegionList($_POST);
?>
<label for="Region">Хороо</label>
<select class="form-control input-sm" required="required" name="region_id" id="Region">
	<option value="">- Select -</option>
	<?php 
		$i = 0;
		foreach($regions as $region) :
		$i = $i + 1;
	?>
	<option value="<?php echo $region['id'] ?>"><?php echo 'Khoroo '.$region['title']; ?></option>
	<?php endforeach; ?>
</select>
<script>
$(document).ready(function () {
	$("#Region").bind("change", function (event) {$.ajax({async:true, data:$("#reportSelect").serialize(), dataType:"html", success:function (data, textStatus) {$("#reportList").html(data);}, type:"post", url:"get_reports.php"});
	return false;});
});
</script>