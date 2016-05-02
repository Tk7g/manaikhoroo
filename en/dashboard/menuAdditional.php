<?php
require(realpath(dirname(__FILE__))."/../classes/District.class.php");
require(realpath(dirname(__FILE__))."/../classes/Article.class.php");

if($_POST['component'] == 3) {
	$districts = District::getDistrictList();
?>
<label class="control-label" for="Additional">Нэмэлт мэдээлэл</label>
<div class="controls">
	<select name="additional" id="DistrictId" required="required">
		<option value="">Сонгоно уу</option>
		<?php foreach($districts as $district) : ?>
		<option value="<?php echo $district['id']; ?>"><?php echo $district['title']; ?></option>
		<?php endforeach; ?>
	</select>
</div>
<?php
} elseif($_POST['component'] == 6) {
	$articles = Article::getArticleList();
?>
<label class="control-label" for="Additional">Нэмэлт мэдээлэл</label>
<div class="controls">
	<select name="additional" id="DistrictId" required="required">
		<option value="">Сонгоно уу</option>
		<?php 
			$k = 0;
			foreach($articles as $article) : 
				$k = $k + 1;
		?>
		<option value="<?php echo $article['id']; ?>"><?php echo $k.'.'.$article['title']; ?></option>
		<?php endforeach; ?>
	</select>
</div>
<?php
}
?>
