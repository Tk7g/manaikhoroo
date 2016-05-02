<?php
	$intro = Article::getList(6, 1);
	$news = Article::getList(2, 4);

	$img = array();
	preg_match_all('/<img[^>]+>/i',$intro[0]['content'], $image_result);
?>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="intro-box">	
				<div class="intro-img">
				<?php
					if($image_result[0] != NULL) {
						preg_match_all('/(style|src)=("[^"]*")/i',$image_result[0][0], $img);
						echo '<a href="news.php?page=info&id='.$intro[0]['id'].'"><img src='.$img[2][0].' class="img-responsive"></a>';
					} else {
									
					}
				?>
				</div>
				<div class="intro-content">
					<div class="intro-title">
						<a href="<?php echo 'news.php?page=info&id='.$intro[0]['id']; ?>"><?php echo $intro[0]['title']; ?></a> 
					</div>
					<div class="intro-text">
					<?php
						$intro_text = preg_replace("/<img[^>]+\>/i", "", $intro[0]['content']);  
						$intro_text = strip_tags($intro[0]['content']);
						echo substr($intro_text, 0, 831);
					?>
					</div>
					<div class="readmore-home">
						<a href="<?php echo 'news.php?page=info&id='.$intro[0]['id']; ?>">Дэлгэрэнгүй</a> 
					</div>
					<div class="intro-footer">
						Нийслэлийн засаг дарга бөгөөд Улаанбаатар хотын захирагч<br/>Э.Бат-Үүл
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">	
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
				<div class="col-md-6">
					<div class="news-box">
						<div class="newsbox-image">
						<?php
							if($image_result[0] != NULL) {
								preg_match_all('/(style|src)=("[^"]*")/i',$image_result[0][0], $news_img);
								echo '<a href="news.php?page=view&id='.$nw['id'].'"><img src='.$news_img[2][0].' class="img-responsive"></a>';
							} else {
									
							}
						?>
						</div>
						<div class="newsbox-title">
							<a href="<?php echo 'news.php?page=view&id='.$nw['id']; ?>"><?php echo $nw['title']; ?></a>
							<span class="newsbox-date">
							&nbsp/<?php echo substr($nw['created'], 0, 10); ?>/
							</span>
						</div>
					</div>
				</div>
			<?php 
				if($i == 2) {
					echo '</div>';
					$i = 0;
				}
				endforeach; 
			?>
		</div>
	</div>
</div>