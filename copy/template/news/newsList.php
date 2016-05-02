<?php
	include(SITE_TEMPLATE."header2.php");
?>

<?php if ( isset( $result ) ) { ?>
<div class="row">
<div class="small-12 columns">
	<div data-alert class="infoAlert alert-box alert round">
  		<?php echo $result; ?>
  		<a href="#" class="close">&times;</a>
	</div>
</div>
</div>
<?php } ?>
<div id="contentPage">
	<div class="newLists">
		<?php 
		foreach($news as $nw) : 
			$news_img = array();
			preg_match_all('/<img[^>]+>/i',$nw['content'], $image_result);
		?>
		<div class="newsRow">
			<div class="newsListTitle">
				<a href="news.php?action=singleContent&id=<?php echo $nw['id']; ?>"><?php echo $nw['title']; ?></a>
			</div>
			<div class="row">
				<div class="small-4 columns">
					<div class="newsRowImage">
						<?php
							if($image_result[0] != NULL) {
								preg_match_all('/(style|src)=("[^"]*")/i',$image_result[0][0], $news_img);
								echo '<a href="news.php?action=singleContent&id='.$nw['id'].'"><img src='.$news_img[2][0].' class="img-responsive"></a>';
							} else {
								
							}
						?>
					</div>
				</div>
				<div class="small-8 columns">
					<div class="newsRowText">
						<?php
							$intro_text = preg_replace("/<img[^>]+\>/i", "", $nw['content']);  
							$intro_text = strip_tags($nw['content']);
							echo substr($intro_text, 0, 100);
						?>...
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="newsPagination">
		<?php for($i=1; $i<=$total_pagination; $i++) { ?>
			<a class="paginationLink" href="news.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php } ?>
	</div>
</div>

<?php
include(SITE_TEMPLATE."footer.php");
?>