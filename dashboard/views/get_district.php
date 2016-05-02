<?php
require("../../classes/District.class.php");

$districts = District::getDistrictList();
?>
<label class="control-label" for="UserGroup">Хэрэглэгчийн бүлэг</label>
<div class="controls">
	<select name="group_id" id="GroupId" required="required">
		<option value="">Сонгоно уу</option>
		<?php foreach($districts as $district) : ?>
		<option value="<?php echo $district['id']; ?>"><?php echo $district['title']; ?></option>
		<?php endforeach; ?>
	</select>
</div>