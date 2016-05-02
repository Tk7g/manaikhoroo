<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/section.php">Хэсгийн хил</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны '; ?>хэсгийн хилийн нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="section.php?action=draw&district=<?php echo $_GET['district']; ?>&region=<?php echo $_GET['region']; ?>" id="" method="post">
			<fieldset>
				<input type="hidden" name="district_id" value="<?php echo $_GET['district']; ?>" id="districtId">
				<input type="hidden" name="region_id" value="<?php echo $_GET['region']; ?>" id="regionId">
				<?php if($_SESSION['login']['group_id'] == 3) { ?>
				<input type="hidden" name="published" value="0" id="regionId">
				<?php } ?>
				<label class="control-label" for="Coordinate">Хэсгийн дугаар</label>
				<input name="title" id="sectionId" required="required">
				
				<label class="control-label" for="Area">Хэсгийн талбайн хэмжээ /м<sup>2</sup>/</label>
				<input name="area" id="AreaNum" required="required" style="margin-bottom: 20px;">
				
				<input type="hidden" name="coordinate" id="SectionCoordinate" />
				<!--<label class="control-label" for="Coordinate">Хэсгийн хилийн координатууд</label>
				<textarea style="width: 90%;" rows="10" name="coordinate" id="SectionCoordinate" required="required"></textarea>-->
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			<div id="dataPanel"></div>
			<div id="btn-panel">
				<input id="reset" value="Ногоон байгууламжийн зураглал устгах" type="button" class="navi" />
			</div>
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

function initialize() {
	var latlngbounds = new google.maps.LatLngBounds();
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
	  addRegion(<?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>');
}

function addRegion(region, image) {
	$.getJSON('<?php echo MAIN_URL; ?>markers.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['khorooCoord'+region] = [];
			var khorooBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				window['khorooCoord'+region][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				khorooBounds.extend(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			window['khorooArea'+region] = new google.maps.Polyline({
    			path: window['khorooCoord'+region],
    			geodesic: true,
    			strokeColor: '#000000',
    			strokeOpacity: 1.0,
    			strokeWeight: 3
  			});
  			$("#AreaNum").val(google.maps.geometry.spherical.computeArea(window['khorooArea'+region].getPath())/10000);
			window['khorooArea'+region].setMap(map);
		}
	});
}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&libraries=geometry&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

</script>