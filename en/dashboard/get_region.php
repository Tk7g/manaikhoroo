<?php
require(realpath(dirname(__FILE__))."/../classes/Region.class.php");

$regions = Region::getRegionList($_POST);
?>
<label class="control-label" id="RegionIdLabel" for="RegionId">Харьяалагдах хороо</label>
<div class="controls">
	<select name="region_id" id="RegionId" required="required">
		<option value="">Сонгоно уу</option>
		<?php foreach($regions as $region) : ?>
		<option value="<?php echo $region['id']; ?>"><?php echo $region['title'].'-р хороо'; ?></option>
		<?php endforeach; ?>
	</select>
</div>