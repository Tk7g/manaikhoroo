<?php
include(WEB_TEMPLATE."header.php");
?>
<div id="homeWrapper">
	<div class="pageContent">
		<div class="row">
			<div class="medium-9 columns">
				<div class="pageTitle animated flipInX">
					<?php echo $page_title; ?>	
				</div>
				<div class="fb-share">
					<div class="fb-like" data-href="https://www.facebook.com/pages/Hunnu-Concrete/836673816358977?fref=ts" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
				</div>
				<div class="newsContent animated flipInX">
					<div class="newsText <?php if($news['category_id'] == 4) { echo 'contactText'; } ?>">
						<?php echo $news['content']; ?>
					</div>
				</div>
				<?php if($news['category_id'] == 4) { ?>
				<div class="mapAddress animated fadeIn">
					<div id="mapBlock" style="height: 400px;">
					</div>
				</div>
				<?php } ?>
				<div class="bannerBottom animated fadeInLeft">
					<ul class="bannerSlider">
  						<li><img src="http://web-site.mn/hunnu/resources/images/banner1.jpg" /></li>
  						<li><img src="http://web-site.mn/hunnu/resources/images/banner2.jpg" /></li>
					</ul>
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
								<li><a href="news.php?action=singleContent&id=13">Нэмэлт</a></li>
								<li><a href="news.php?action=singleContent&id=14">Тээвэрлэлт, техник хэрэгсэл</a></li>
								<li><a href="news.php?action=singleContent&id=15">Бетон цутгалтын үйлчилгээний авто бааз</a></li>
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
					<div class="fb-box-content">
						<div class="fb-page" data-href="https://www.facebook.com/pages/Hunnu-Concrete/836673816358977?fref=ts" data-width="220" data-hide-cover="true" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/pages/Hunnu-Concrete/836673816358977?fref=ts"><a href="https://www.facebook.com/pages/Hunnu-Concrete/836673816358977?fref=ts">Hunnu Concrete</a></blockquote></div></div>
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
<?php if($news['category_id'] == 4) { ?>
<script>

var map;

function initialize() {
	var mapOptions = {
		zoom: 13,
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

</script>
<?php } ?>
<?php
include(WEB_TEMPLATE."footer.php");
?>