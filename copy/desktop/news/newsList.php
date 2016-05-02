<?php
include(WEB_TEMPLATE."header.php");
?>
<div id="homeWrapper">
	<div class="pageContent">
		<div class="row">
			<div class="medium-9 columns">
				<div class="newsListPageTitle animated fadeInDown">
					<h1><?php echo $page_title; ?></h1>	
				</div>
				<div class="newLists">
				<?php 
				foreach($news as $nw) : 
					$news_img = array();
					preg_match_all('/<img[^>]+>/i',$nw['content'], $image_result);
				?>
					<div class="newsRow animated fadeInUp">
						<div class="newsListTitle">
							<a href="news.php?action=singleContent&id=<?php echo $nw['id']; ?>"><?php echo $nw['title']; ?></a>
						</div>
						<div class="newsListContent">
							<div class="newsListImage">
							<?php
							if($image_result[0] != NULL) {
								preg_match_all('/(style|src)=("[^"]*")/i',$image_result[0][0], $news_img);
								echo '<a href="news.php?action=singleContent&id='.$nw['id'].'"><img src='.$news_img[2][0].' class="img-responsive"></a>';
							} else {
								
							}
							?>
							</div>
							<div class="newsListIntro">
							<?php
								$intro_text = preg_replace("/<img[^>]+\>/i", "", $nw['content']);  
								$intro_text = strip_tags($nw['content']);
								echo substr($intro_text, 0, 400);
							?>...
							</div>
						</div>
						<div class="newsListReadmore">
							<a href="news.php?action=singleContent&id=<?php echo $nw['id']; ?>">Дэлгэрэнгүй</a>
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
			<div class="medium-3 columns">
				<div class="sideBlock">
					<div class="orderSideBlock animated fadeInDown">
						<a href="order.php">
							<p class="orderSideTitle">Онлайн захиалга</p>
							<p>Захиалга өгөх, захиалгын явц харах</p>
						</a>
					</div>
					<div class="sideCategory animated fadeInRight">
						<div class="sideCatTitle">
							Үйлчилгээ
						</div>
						<div class="sideCat">
							<ul>
								<li><a href="news.php?action=singleContent&id=4">Лаборатори</a></li>
								<li><a href="news.php?action=singleContent&id=5">Цемент</a></li>
								<li><a href="news.php?action=singleContent&id=6">Дайрга</a></li>
								<li><a href="news.php?action=singleContent&id=7">Элс</a></li>
								<li><a href="#">Нэмэлт</a></li>
								<li><a href="#">Тээвэрлэлт, техник хэрэгсэл</a></li>
								<li><a href="#">Бетон цутгалтын үйлчилгээний авто бааз</a></li>
							</ul>
						</div>
					</div>
					<div class="sideContact animated fadeInUp">
						<div class="sideCatTitle">
							Холбоо барих
						</div>
						<div class="sideContactText">
							<p><strong>Хаяг:</strong> Улаанбаатар, Сонгинохайрхан дүүрэг, 18-р хороо, Энхтайваны өргөн чөлөө, 157</p>
							<p style="font-size: 24px; line-height: 24px; color: #FEDE00;"><strong>93090908</strong></p>
							<p style="font-size: 24px; line-height: 24px; color: #FEDE00;"><strong>93090906</strong></p>
							<p><strong>И-мэйл:</strong> info@hunnu.asia</p>
							<p><strong>Вэб:</strong> www.hunnu.asia</p>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<script>
$(document).ready(function(){
  $('.bannerSlider').bxSlider({
	mode: 'fade',
	captions: false
  });;
});
</script>
<?php
include(WEB_TEMPLATE."footer.php");
?>