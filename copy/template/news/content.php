<?php
	include(SITE_TEMPLATE."header2.php");
?>
<div class="contentTitle">
	<div class="row">
		<div class="small-12 columns text-center">
			<?php echo $news['title']; ?>
		</div>
	</div>
</div>
<div class="contentText">
	<div class="row">
		<div class="small-12 columns">
			<?php echo $news['content']; ?>
		</div>
	</div>
</div>
<?php
	include(SITE_TEMPLATE."footer.php");
?>