<div id="news-lists">
	<div class="container">
		<?php 
			$i = 0;
			foreach($news as $nw) :
			$i = $i + 1;
			if($i == 1) {
				echo '<div class="row">';
			}
			$news_img = array();
			preg_match_all('/<img[^>]+>/i',$nw['content'], $image_result);
		?>
			<div class="col-md-3">
				<div class="list-box">
					<div class="list-image">
					<?php
						if($image_result[0] != NULL) {
							preg_match_all('/(style|src)=("[^"]*")/i',$image_result[0][0], $news_img);
							echo '<a href="news.php?page=view&id='.$nw['id'].'"><img src='.$news_img[2][0].' class="img-responsive"></a>';
						} else {
							
						}
					?>	
					</div>	
					<div class="list-title">
						<a href="news.php?page=view&id=<?php echo $nw['id']; ?>"><?php echo $nw['title']; ?></a>
					</div>
					<div class="list-date">
						<?php echo substr($nw['created'], 0, 10); ?>
					</div>
					<div class="list-content">
					<?php
						$intro_text = preg_replace("/<img[^>]+\>/i", "", $nw['content']);  
						$intro_text = strip_tags($nw['content']);
						echo substr($intro_text, 0, 300);
					?>
					</div>
					<div class="list-readmore">
						<a href="news.php?page=view&id=<?php echo $nw['id']; ?>">Дэлгэрэнгүй</a>
					</div>
				</div>
			</div>
		<?php
			if($i == 4) {
				echo '</div>';
				$i = 0;
			}
			endforeach;
		?>
	</div>
</div>