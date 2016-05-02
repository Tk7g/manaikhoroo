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
	<div class="newsContent">
		<div class="newsText <?php if($news['category_id'] == 4) { echo 'contactText'; } ?>">
			<?php echo $news['content']; ?>
		</div>
	</div>
	<?php if($news['category_id'] == 4) { ?>
		<div class="mapAddress">
			<div id="mapBlock" style="height: 300px;">
			</div>
		</div>
	<?php } ?>
</div>

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
include(SITE_TEMPLATE."footer.php");
?>