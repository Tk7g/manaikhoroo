<?php
include(SITE_TEMPLATE. "header.php");
?>

<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-report">
					<div class="reportBtnRow">
						<a class="reportBackBtn" href="javascript:window.history.back()">
							<i class="glyphicon glyphicon-arrow-left"></i>
							<div>Буцах</div>
						</a>
					</div>
					<div class="profileHeader">
					<div class="profileCol1">
						<div class="profileHeaderSub">
							Хороо
						</div>
						<div class="profileHeaderTitle">
							<?php echo $district['title'].' '.$region['title']; ?>
						</div>
					</div>
					<div class="profileCol2">
							<div class="reportMsgWarning">
								<?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны мэдээлэл ороогүй байна.'; ?>
							</div>
					</div>
					</div>
					<div class="profileTop">
						<div class="profileCol1">
							<div class="profileTopMap">
								<div id="profileMainMap" style="height: 170px;">
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
	
	<?php foreach($regions as $reg) : ?>
	var regionArea<?php echo $reg['id']; ?>;
	<?php endforeach; ?>

function initialize() {
	var mapOptions = {
		zoom: 8,
		center: new google.maps.LatLng(47.918506, 106.917750),
		panControl: false,
		mapTypeControl: false,
		zoomControl: false,
		scaleControl: false,
		streetViewControl: false,
		draggable: false,
		scrollwheel: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP
		
	};
	
	map = new google.maps.Map(document.getElementById('profileMainMap'),
      mapOptions);
	
	<?php foreach($regions as $reg) : ?>
	addRegion(<?php echo $district['id'] ?>, <?php echo $reg['id']; ?>);
	<?php endforeach; ?>
	
	fitBoundary(<?php echo $region['id']; ?>, map);
}

function fitBoundary(region, where) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			var khorooBounds = [];
			var khorooBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				khorooBounds.extend(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			regionArea = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#28324e',
				strokeOpacity: 0,
				strokeWeight: 2,
				fillColor: '#FFF',
				fillOpacity: 0
			});
			myFitBounds(where, khorooBounds);
			regionArea.setMap(where);
		}
	});
}

function myFitBounds(myMap, bounds) {
    myMap.fitBounds(bounds);

    var overlayHelper = new google.maps.OverlayView();
    overlayHelper.draw = function () {
        if (!this.ready) {
            var projection = this.getProjection(),
                zoom = getExtraZoom(projection, bounds, myMap.getBounds());
            if (zoom > 0) {
                myMap.setZoom(myMap.getZoom() + zoom);
            }
            this.ready = true;
            google.maps.event.trigger(this, 'ready');
        }
    };
    overlayHelper.setMap(myMap);
}

// LatLngBounds b1, b2 -> zoom increment
function getExtraZoom(projection, expectedBounds, actualBounds) {
    var expectedSize = getSizeInPixels(projection, expectedBounds),
        actualSize = getSizeInPixels(projection, actualBounds);

    if (Math.floor(expectedSize.x) == 0 || Math.floor(expectedSize.y) == 0) {
        return 0;
    }

    var qx = actualSize.x / expectedSize.x;
    var qy = actualSize.y / expectedSize.y;
    var min = Math.min(qx, qy);

    if (min < 1) {
        return 0;
    }

    return Math.floor(Math.log(min) / Math.log(2) /* = log2(min) */);
}

// LatLngBounds bnds -> height and width as a Point
function getSizeInPixels(projection, bounds) {
    var sw = projection.fromLatLngToContainerPixel(bounds.getSouthWest());
    var ne = projection.fromLatLngToContainerPixel(bounds.getNorthEast());
    return new google.maps.Point(Math.abs(sw.y - ne.y), Math.abs(sw.x - ne.x));
}

function addRegion(district, region) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			if(region == <?php echo $region['id']; ?>) {
				window['regionArea'+region] = new google.maps.Polygon({
					paths: regionCoord,
					strokeColor: '#000',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#f7c567',
					fillOpacity: 1
				});
			} else {
				window['regionArea'+region] = new google.maps.Polygon({
					paths: regionCoord,
					strokeColor: '#000',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#FFF',
					fillOpacity: 1
				});
			}
			window['regionArea'+region].setMap(map);
		}
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

<?php
include(SITE_TEMPLATE. "footer.php");
?>