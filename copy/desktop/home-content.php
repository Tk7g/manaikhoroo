<div id="homeWrapper">
	<div class="homeRow BlockRow1">
		<div class="row">
			<div class="large-6 columns">
				<div id="BlockBox1" class="textLongBlock animated fadeInLeft">
					<?php $block = Block::getBlock(1); ?>
					<div class="block_box">
						<div class="yellow_box block_inner" style="height: 250px;">
							<div class="block_title1">
								<?php echo $block['title']; ?>
							</div>
							<div class="block_content">
								<?php echo $block['content']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $block = Block::getBlock(2); ?>
			<div class="large-6 columns">
				<div id="BlockBox2" class="imageTextBlock animated fadeInRight">
					<div class="row">
						<div class="large-6 columns">
							<div class="block_box">
								<div class="blockImageBox" style="height: 250px;">
									<div class="blockImage">
										<a href="<?php echo $block['link']; ?>">
											<img src="<?php echo SITE_URL.''.$block['image']; ?>" />
										</a>
									</div>
								</div>
								<div class="blockImageTitle">
									<a href="<?php echo $block['link']; ?>"></a>
								</div>
							</div>
						</div>
						<div class="large-6 columns">
							<div class="block_box">
								<div class="black_box block_inner" style="height: 250px;">
									<div class="block_title2">
										<a class="boxBlockTitle" href="<?php echo $block['link']; ?>"><?php echo $block['title']; ?></a>
									</div>
									<div class="block_content2">
										<?php echo $block['content']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="homeRow BlockRow2">
		<div class="row">
			<div class="large-6 columns">
				<div class="block_box animated fadeInDown">
					<?php $block = Block::getBlock(3); ?>
					<div class="black_box block_inner" style="height: 496px;">
						<div class="block_title2">
							<a href="<?php echo $block['link']; ?>"><?php echo $block['title']; ?></a>
						</div>
						<div class="block_content3">
							<?php echo $block['content']; ?>
						</div>
						<div class="block_readmore3">
							<a href="<?php echo $block['link']; ?>">Дэлгэрэнгүй</a>
						</div>
					</div>
				</div>
			</div>
			<div class="large-6 columns">
				<div id="BlockBox4" class="imageTextBlock animated zoomIn">
					<div class="row">
						<div class="large-6 columns">
							<div class="block_box">
								<div class="yellow_box block_inner" style="height: 248px;">
									<div class="block_title1">
										<a class="boxBlockTitle" href="order.php">Онлайн захиалга</a>
									</div>
									<div class="block_content text-center">
										Захиалга өгөх, захиалгын явц харах
									</div>
								</div>
							</div>
						</div>
						<div class="large-6 columns">
							<div class="block_box">
								<div class="blockImageBox" style="height: 248px;">
									<div class="blockImage">
										<a href="order.php">
											<img src="<?php echo SITE_URL.'resources/images/home/order.jpg'; ?>" />
										</a>
									</div>
								</div>
								<div class="blockImageTitle">
									<a href="order.php"></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
						<div class="block_box animated fadeInUp">
							<div class="blockNewsBox">
								<div class="blockImageBox" style="height: 248px;">
									<a href="news.php">
										<img src="<?php echo SITE_URL.'resources/images/home/news.jpg'; ?>" />
									</a>
								</div>
								<div class="blockImageTitle">
									<a href="news.php"></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="homeRow BlockRow3">
		<div class="row">
			<div class="large-6 columns">
				<div class="BlockRow4">
					<div class="row">
						<div class="large-6 columns">
							<div class="block_box animated flipInX">
								<div class="blockNewsBox2">
									<div class="blockNewsImage2">
										<a href="#">
											<img src="<?php echo SITE_URL.'resources/images/banner.jpg'; ?>" />
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="large-6 columns">
							<div class="block_box animated fadeInUp">
								<div class="blockListBox">
									<ul>
										<li><a href="news.php?action=singleContent&id=4">Лаборатори</a></li>
										<li><a href="news.php?action=singleContent&id=5">Цемент</a></li>
										<li><a href="news.php?action=singleContent&id=6">Дайрга</a></li>
										<li><a href="news.php?action=singleContent&id=7">Элс</a></li>
										<li><a href="news.php?action=singleContent&id=13">Нэмэлт</a></li>
										<li><a href="news.php?action=singleContent&id=14">Тээвэрлэлт, техник хэрэгсэл</a></li>
										<li><a href="news.php?action=singleContent&id=15">Бетон цутгалтын үйлчилгээний авто бааз</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="large-6 columns">
				<div class="BlockRow4">
					<div class="row">
						<div class="large-12 columns">
							<div class="block_box animated fadeInRight">
								<div class="black_box block_inner2" style="height: 140px;">
									<div class="block_title4">
										<a href="#">Ухаалаг систем</a>
									</div>
									<div class="block_content3 no-border-table">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tbody>
												<tr>
													<td width="50%"><img src="<?php echo SITE_URL.'resources/images/icons/gps1.png'; ?>" style="float: left; height: 25px;" /> GPS - ХЯНАЛТЫН СИСТЕМ</td>
													<td width="50%"><img src="<?php echo SITE_URL.'resources/images/icons/mobile1.png'; ?>" style="float: left; height: 25px;" /> MOBILE APPLICATION - СИСТЕМ</td>
												</tr>
												<tr>
													<td><img src="<?php echo SITE_URL.'resources/images/icons/rfid1.png'; ?>" style="float: left; height: 25px;" /> RFID - БОГИНО ХОЛБООНЫ СИСТЕМТЭЙ</td>
													<td><img src="<?php echo SITE_URL.'resources/images/icons/camera1.png'; ?>" style="float: left; height: 25px;" /> КАМЕРЫН ХЯНАЛТЫН СИСТЕМ</td>
												</tr>
											</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="large-6 columns">
							<div class="block_box animated slideInUp">
								<div class="map_box">
									<div id="mapBlock" style="height: 205px;">
									</div>
								</div>
							</div>
						</div>
						<div class="large-6 columns">
							<div class="block_box animated slideInRight">
								<div class="yellow_box block_inner3" style="height: 205px;">
									<div class="block_content text-center">
										<p><strong>Хаяг:</strong> Улаанбаатар, Сонгинохайрхан дүүрэг, 18-р хороо, Энхтайваны өргөн чөлөө, 157</p>
										<p style="font-size: 24px; line-height: 24px;"><strong>93090908</strong></p>
										<p style="font-size: 24px; line-height: 24px;"><strong>93090906</strong></p>
										<p><strong>И-мэйл:</strong> info@hunnu.asia</p>
										<p><strong>Вэб:</strong> www.hunnu.asia</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

var map;

function initialize() {
	var mapOptions = {
		zoom: 11,
		center: new google.maps.LatLng(47.911032, 106.815785)
	};
	map = new google.maps.Map(document.getElementById('mapBlock'),
      mapOptions);
      
    var image = '<?php echo SITE_URL; ?>resources/images/map-marker.png';
	var myLatLng = new google.maps.LatLng(47.911032, 106.815785);
	var beachMarker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      icon: image
	});
}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

function imageTextBlockHover() {
	$(".imageTextBlock").mouseover(function(){
		$(this).find(".blockImageBox").addClass("imageBoxBlockHover");
		$(this).find(".blockImageBox").removeClass("imageBoxBlock");
		var textTitle = $(this).find(".boxBlockTitle").text();
		$(this).find(".blockImageTitle a").text(textTitle);
	});
	$(".imageTextBlock").mouseout(function(){
		$(this).find(".blockImageBox").removeClass("imageBoxBlockHover");
		$(this).find(".blockImageBox").addClass("imageBoxBlock");
		$(this).find(".blockImageTitle a").text("");
	});
}

function newsImageHover() {
	$(".blockNewsBox").mouseover(function(){
		$(this).find(".blockImageBox").addClass("imageBoxBlockHover");
		$(this).find(".blockImageBox").removeClass("imageBoxBlock");
		$(this).find(".blockImageTitle a").text('Мэдээ, мэдээлэл');
	});
	$(".blockNewsBox").mouseout(function(){
		$(this).find(".blockImageBox").removeClass("imageBoxBlockHover");
		$(this).find(".blockImageBox").addClass("imageBoxBlock");
		$(this).find(".blockImageTitle a").text("");
	});
}

newsImageHover();
imageTextBlockHover();

(function($) {

  $(window).load(function() {
    $(document.body).fadeIn(1000);
  });

})(jQuery);


</script>