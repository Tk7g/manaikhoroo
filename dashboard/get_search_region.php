<?php
require(realpath(dirname(__FILE__))."/../classes/Region.class.php");

$regions = Region::getRegionList($_POST['district']);
?>
<option value="">Сонгоно уу</option>
<?php foreach($regions as $region) : ?>
<option value="<?php echo $region['id']; ?>"><?php echo $region['title'].'-р хороо'; ?></option>
<?php endforeach; ?>