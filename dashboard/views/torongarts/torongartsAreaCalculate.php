<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="torongarts.php?action=calculate" id="" method="post">
			<fieldset>
				
				<label class="control-label" for="Area">Хэсгийн талбайн хэмжээ /м<sup>2</sup>/</label>
				<input name="area" id="AreaNum" required="required">
				
				<label class="control-label" for="Coordinate">Торон гарцын координатууд</label>
				<textarea style="width: 90%;" rows="10" name="coordinate" id="SectionCoordinate" required="required"></textarea>
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			<div id="dataPanel"></div>
			<div class="form-actions">
				<button type="submit" name="saveSection" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>
<script>

var map;

var contentString = '';
var polygonSection = '';
var khorooCoord<?php echo $region['id']; ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];

<?php foreach($sections as $section) : ?>
	var sectionCoord<?php echo $section['id']; ?> = [];
<?php endforeach; ?>

function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
	
	<?php foreach($districts as $district) : ?>
		<?php 
			$regions = Region::getRegionList($district['id']);
			foreach($regions as $region) : 
		?>
			<?php
				$sections = Torongarts::getRegionTorongarts($region['id']); 
				foreach($sections as $section) :
			?>
			addSection(97);
			<?php endforeach; ?>
		<?php endforeach; ?>
	<?php endforeach; ?>
}

function addSection(section) {
	$.getJSON('<?php echo MAIN_URL; ?>torongarts.php?action=torongartsBorder&section='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['sectionCoord'+section] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['sectionCoord'+section][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['sectionArea'+section] = new google.maps.Polygon({
    			path: window['sectionCoord'+section],
    			 strokeColor: '#000000',
    			 strokeOpacity: 0,
    			 strokeWeight: 0,
    			 fillColor: '#FF0000',
    			 fillOpacity: 0.8
  			});
			window['sectionArea'+section].setMap(map);
		}
	});
}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&libraries=drawing&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

</script>