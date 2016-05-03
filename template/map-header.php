<?php
	$current_year = Year::getDefaultYear();
	$res = Marker::homeView();
	$districts = District::getDistrictList();
	$results = Marker::districtView();
	$pop_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$kin_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$school_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");

	foreach($results['districts'] as $district) {
		$regions[$district['id']] = Region::getRegionList($district['id']);
		$floods[$district['id']] = Risks::getDistrictRisks($district['id']);
		$pls[$district['id']] = Playground::getDistrictPlaygrounds($district['id']);
		$roads[$district['id']] = Road::getDistrictRoads($district['id']);
		foreach($regions[$district['id']] as $reg) {
			$sections[$reg['id']] = Section::getRegionSections($reg['id']);
			foreach($sections[$reg['id']] as $sec) {
				$sec_info[$sec['id']] = Info::SectionInfo($reg['id'], $district['id'], $sec['title'], $current_year['year']);
				if($sec_info[$sec['id']] != NULL) {

				if($sec_info[$sec['id']]['population_density'] <= 15) {
					$pop_district[$sec['id']] = $pop_color[0];
				} elseif($sec_info[$sec['id']]['population_density'] > 15 && $sec_info[$sec['id']]['population_density'] <= 30) {
					$pop_district[$sec['id']] = $pop_color[1];
				} elseif($sec_info[$sec['id']]['population_density'] > 30 && $sec_info[$sec['id']]['population_density'] <= 35) {
					$pop_district[$sec['id']] = $pop_color[2];
				} else {
					$pop_district[$sec['id']] = $pop_color[3];
				}

				if($sec_info[$sec['id']]['kin_ratio'] <= 25 ) {
					$kin_district[$sec['id']] = $kin_color[0];
				} elseif($sec_info[$sec['id']]['kin_ratio'] > 25 && $sec_info[$sec['id']]['kin_ratio'] <= 50) {
					$kin_district[$sec['id']] = $kin_color[1];
				} elseif($sec_info[$sec['id']]['kin_ratio'] > 50 && $sec_info[$sec['id']]['kin_ratio'] <= 75) {
					$kin_district[$sec['id']] = $kin_color[2];
				} else {
					$kin_district[$sec['id']] = $kin_color[3];
				}

				if($sec_info[$sec['id']]['school_ratio'] <= 25 ) {
					$school_district[$sec['id']] = $school_color[0];
				} elseif($sec_info[$sec['id']]['school_ratio'] > 25 && $sec_info[$sec['id']]['school_ratio'] <= 50) {
					$school_district[$sec['id']] = $school_color[1];
				} elseif($sec_info[$sec['id']]['school_ratio'] > 50 && $sec_info[$sec['id']]['school_ratio'] <= 75) {
					$school_district[$sec['id']] = $school_color[2];
				} else {
					$school_district[$sec['id']] = $school_color[3];
				}

				}
			}
		}
	}
?>
<div class="container" id="topMapHeader">
	<div class="row">
	<div class="col-md-3">
			<div class="homemap-box">
				<div class="homemap-title">
					Иргэдийн оролцоотой хийгдсэн Улаанбаатар хотын газрын зураглалын сан
				</div>
				<div class="homemap-desc">
					Иргэдийн оролцоотой хийгдсэн Улаанбаатар хотын газрын зураглалын санд тавтай морилно уу. Доорх сонголтоос эсвэл газрын зураг дээрх дүүргүүд дээр дарж дүүрэг, хороодын газрын зураглалын мэдээллийг үзнэ үү.
				</div>
				<!--<div class="homemap-swticher">
					<div class="switch-button switch-checked">
						Дүүрэг
					</div>
					<div class="switch-button">
						Хороо
					</div>
				</div>-->
				<div class="homemap-select">
					<select data-placeholder="Дүүрэг, хороогоор сонгох" class="chosen-select" style="width:220px;" tabindex="2">
						<option value=""></option>
						<?php foreach($districts as $dist) : ?>
						<option class="district-option" value="indicator.php?action=regionView&district=<?php echo $dist['id']; ?>"><?php echo $dist['title'].' дүүрэг'; ?></option>
						<?php
							foreach($regions[$dist['id']] as $reg) :
						?>
							<option class="region-option" value="indicator.php?action=regionView&district=<?php echo $dist['id']; ?>&region=<?php echo $reg['id']; ?>"><?php echo $dist['title'].' '.$reg['title'].'-р хороо'; ?></option>
						<?php
							endforeach;
						endforeach;
						?>
					</select>
				</div>
		<div id="home-mapbox">
			<h3>Харагдац</h3>

			<ul class="list-group">
				<li class="list-group-item colorRow">
					<div class="color-checker">
						<div class="color-checkbox" data="pop-density">
						</div>
						<div class="color-checked" data="pop-density">
						</div>
					</div>
					<div class="color-description">
						<div class="color-title">
							Хүн амын нягтаршил
						</div>
					</div>
				</li>
				<li class="list-group-item colorRow">
					<div class="color-checker">
						<div class="color-checkbox" data="kin-density">
						</div>
						<div class="color-checked" data="kin-density">
						</div>
					</div>
					<div class="color-description">
						<div class="color-title">
							Цэцэрлэгт хамрагддаггүй [%]
						</div>
					</div>
				</li>
				<li class="list-group-item colorRow">
					<div class="color-checker">
						<div class="color-checkbox" data="school-density">
						</div>
						<div class="color-checked" data="school-density">
						</div>
					</div>
					<div class="color-description">
						<div class="color-title">
							Сургуульд хамрагддаггүй [%]
						</div>
					</div>
				</li>
			</ul>


			<div class="colorDataRow panel panel-default" style="display: none;">
			<div  class="panel-body">
				<div id="popDensityColor">
					<div class="colorTitle">
						Тэмдэглэгээ
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #ffdc9c;">
						</div>
						<div class="colorBoxNumber">
							0 - 15
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							16 - 30
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							31 - 35
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							36 +
						</div>
					</div>
				</div>
				<div id="kinDensityColor">
					<div class="colorTitle">
						Тэмдэглэгээ
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #ffdc9c;">
						</div>
						<div class="colorBoxNumber">
							0% - 10%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							11% - 20%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							21% - 30%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							> 30%
						</div>
					</div>
				</div>
				<div id="schoolDensityColor">
					<div class="colorTitle">
						Тэмдэглэгээ
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #ffdc9c;">
						</div>
						<div class="colorBoxNumber">
							0% - 10%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							11% - 20%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							21% - 30%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							> 30%
						</div>
					</div>

			</div>
		</div>
			</div>
			</div>
			
			</div>
		</div>
		<div class="col-md-6">
			<div id="home-map">
			</div>
		</div>
		<div class="col-md-3">
			<div id="marker-tags" class="panel panel-default">
				<div class="panel-heading">Тэмдэглэгээ</div>
				<div class="panel-body">
				<div class="panel-group" id="marker-select" role="tablist" aria-multiselectable="true" aria-expanded="false">
	  <div class="panel panel-default">
	    
	    
		<?php 
			$marker_groups = Marker::getMarkerGroups();
			$m = 0;
			foreach($marker_groups as $m_group) :
		?>	
	    <div class="panel-heading" role="tab" id="heading<?php echo $m_group['id'];?>" data="<?php echo $m_group['id']; ?>">
	      <h4 class="panel-title">
	        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $m_group['id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $m_group['id'];?>">
	          <?php echo $m_group['title']; ?> <span class="caret"></span>
	        </a>
	      </h4>
	    </div>
	    	
	    <div id="collapse<?php echo $m_group['id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $m_group['id'];?>">
	      <ul class="list-group">
	      	  <?php
					$type_markers[$m] = Marker::getGroupMarkers($m_group['id']);
					foreach($type_markers[$m] as $t_marker) :
			?>
			  <li class="list-group-item marker-row">
			  	<div class="marker-image">
					<img src="<?php echo $t_marker['image']; ?>" />
					</div>
					<div class="marker-checker">
						<div class="marker-checkbox" data="<?php echo $t_marker['id']; ?>">
						</div>
						<div class="marker-checked" data="<?php echo $t_marker['id']; ?>">
						</div>
					</div>
					<div class="marker-description">
						<div class="marker-title">
							<?php echo $t_marker['title']; ?>
						</div>
					</div>
			  </li>
				<?php endforeach;?>
			</ul>
	    </div>
		<?php endforeach;?>
	  </div>
	  
	 
	  </div>	
	
	<div class="panel panel-default">
		<div class="panel-body">
		<div class="marker-row">
			<div class="marker-image">
			<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/line1.png" />
			</div>
			<div class="marker-checker">
				<div class="marker-checkbox" data="sectionline">
				</div>
				<div class="marker-checked" data="sectionline">
				</div>
			</div>
			<div class="marker-description">
				<div class="marker-title">
					Хэсгийн хил
				</div>
			</div>
			</div>
		</div>
	</div>
				<?php //include(SITE_TEMPLATE.'markers/home-marker.php'); ?>
			</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/jsts.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/shared-map.js"></script>
<script type="text/javascript">
var inregions = [];
var regions = [];

var districts = [];
var sections = [];

var flids = [
<?php
	foreach($results['districts'] as $dist) :
		foreach($floods[$dist['id']] as $fld) {
?>
	<?php echo $fld['id']; ?>,
<?php
		}
	endforeach;
?>
-1];
flids.pop();

var pgids = [
<?php
foreach($results['districts'] as $dist) :
	foreach(pls[$dist['id']] as $fld) {
?>
<?php echo $pl['id']; ?>,
<?php
		}
	endforeach;
?>
-1];
pgids.pop();

var rdids = [
<?php foreach($results['districts'] as $dist) :
		foreach(roads[$dist['id']] as $fld) {	?>
<?php echo $rd['id']; ?>,
<?php } endforeach; ?>
-1];
rdids.pop();

function initialize() {
	var mapOptions = {
		zoom: 10,
		center: new google.maps.LatLng(47.918506, 106.917750),
		panControl: false,
		streetViewControl: false,
		maxZoom: 16,
		minZoom: 8,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('home-map'), mapOptions);
	infoWindow = new google.maps.InfoWindow({});

  <?php foreach($res['districts'] as $district) : ?>
		addDistrictTitle(<?php echo $district['id']; ?>, <?php echo $district['titlePosition'] ?>, <?php echo '"'.$district['image'].'"'; ?>);
	<?php endforeach; ?>

  $(".colorRow").click(function(){
		var colorType = $(this).find(".color-checkbox").attr("data");
		if($(this).attr("data") == "checked") {
			$('.colorDataRow').hide();
			$(this).find(".color-checkbox").show();
			$(this).find(".color-checked").hide();
			$(this).removeAttr("data");
			if($(this).find(".color-checkbox").attr("data") == "pop-density") {
				$("#popDensityColor").hide();
				removeRegionColor();
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").hide();
				removeRegionColor();
			}
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").hide();
				removeRegionColor();
			}
		} else {
			$('.colorDataRow').show();
			$(".color-checker").each(function() {
				$(this).removeAttr("data");
				$(this).find(".color-checked").hide();
				$(this).find(".color-checkbox").show();
				$("#popDensityColor").hide();
				$("#kinDensityColor").hide();
				$("#schoolDensityColor").hide();
			});
			$(this).find(".color-checkbox").hide();
			$(this).find(".color-checked").show();
			$(this).attr("data", "checked");

			if($(this).find(".color-checkbox").attr("data") == "pop-density") {
				$("#popDensityColor").show();
				styleByRegion = {
					<?php foreach($results['districts'] as $dist) : ?>
						<?php foreach($regions[$dist['id']] as $reg) : ?>
							<?php foreach($sections[$reg['id']] as $sec) : ?>
<?php if(isset($pop_district[$sec['id']]) ) { ?>'<?php echo $sec['id']; ?>':'<?php echo $pop_district[$sec['id']]; ?>',<?php } ?>
					  <?php endforeach; ?>
				  <?php endforeach; ?>
				<?php endforeach; ?>

				'x': 0
			  };
				setRegionColor('x', 1);
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").show();
				styleByRegion = {
					<?php foreach($results['districts'] as $dist) : ?>
						<?php foreach($regions[$dist['id']] as $reg) : ?>
							<?php foreach($sections[$reg['id']] as $sec) : ?>
<?php if(isset($kin_district[$sec['id']])) { ?>'<?php echo $sec['id']; ?>':'<?php echo $kin_district[$sec['id']]; ?>',<?php } ?>
            <?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
				'x': 0
			  };
				setRegionColor('x', 1);
			}
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").show();
				styleByRegion = {
					<?php foreach($results['districts'] as $dist) : ?>
						<?php foreach($regions[$dist['id']] as $reg) : ?>
							<?php foreach($sections[$reg['id']] as $sec) : ?>
<?php if(isset($school_district[$sec['id']])) { ?>'<?php echo $sec['id']; ?>':'<?php echo $school_district[$sec['id']]; ?>',<?php } ?>
            <?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
				'x': 0
			  };
				setRegionColor('x', 1);
			}
		}
	});

<?php
	foreach($res['districts'] as $district) {
		echo 'addDistrict('.$district['id'].', "'.$district['title'].'"); ';
?>
	addDistrictTitle(<?php echo $district['id']; ?>, <?php echo $district['titlePosition'] ?>, <?php echo '"'.$district['image'].'"'; ?>);
<?php
	}
?>

	$(".marker-row").click(function(e){
		var box = e.currentTarget;
		var markerType = $(box).find(".marker-checkbox").attr("data");
		if($(box).attr("data") == "checked") {
			$(box).find(".marker-checkbox").show();
			$(box).find(".marker-checked").hide();
			$(box).removeAttr("data");
			if(markerType == "flood-pol") {
				removeFloods();
			} else if(markerType == "pl-pol") {
				removePlaygrounds();
			} else if(markerType == "road-pol") {
				removeRoads();
				map.setOptions({styles: roadStylesRemove});
			} else if(markerType == "sectionline") {
				removeSections();
			} else if(markerType == "cableline") {
					removeMobinet();
			} else if(markerType == "gmobileline") {
					removeGmobile();
			} else if(markerType == "tnline") {
					removeTopnet();
			} else if(markerType == "sansarline") {
					removeSansar();
			} else if(markerType == "uniline") {
					removeUnivision();
			} else if(markerType == "magicline") {
					removeMagicnet();
			} else if(markerType == "niislelline") {
					removeNiislel();
			} else if(markerType == "zhutline") {
					removeZhut();
			} else {
				$(".infobox-type"+markerType).empty();
				removeMarker(markerType);
			}
		} else {
			$(box).find(".marker-checkbox").hide();
			$(box).find(".marker-checked").show();
			$(box).attr("data", "checked");
			if(markerType == "flood-pol") {
				addFloods();
			} else if(markerType == "pl-pol") {
				addPlaygrounds();
			} else if(markerType == "road-pol") {
				addRoads();
				map.setOptions({styles: roadStyles});
			} else if(markerType == "sectionline") {
				addSections();
			} else if(markerType == "cableline") {
					addMobinet();
			} else if(markerType == "gmobileline") {
					addGmobile();
			} else if(markerType == "tnline") {
					addTopnet();
			} else if(markerType == "sansarline") {
					addSansar();
			} else if(markerType == "uniline") {
					addUnivision();
			} else if(markerType == "magicline") {
					addMagicnet();
			} else if(markerType == "niislelline") {
					addNiislel();
			} else if(markerType == "zhutline") {
					addZhut();
			} else {
				$.ajax({
					type: "post",
					data: { type: markerType },
					url:"infobox.php",
					success:function (result) {
						$(".infobox-type"+markerType).html(result);
					}
				});
				addMarker(markerType);
			}
		}
	});

	$(".marker-checker-walk").click(function(){
		var circleType = $(this).find(".marker-checkbox").attr("data");
		if($(this).attr("data") == "checked") {
			$(this).find(".marker-checkbox").show();
			$(this).find(".marker-checked").hide();
			$(this).removeAttr("data");
			removeWalk(circleType);
		} else {
			$(this).find(".marker-checkbox").hide();
			$(this).find(".marker-checked").show();
			$(this).attr("data", "checked");
			addWalk(circleType);
		}
	});

}

function addDistrictTitle(districtid, distlat, distlng, image) {
	var zoomlevel = map.getZoom();
	var levelmultiplier = zoomlevel;
	var iconImg = {
		url: '<?php echo MAIN_FOLDER; ?>'+image,
   	size: new google.maps.Size(levelmultiplier*10, levelmultiplier*2),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(levelmultiplier*5,levelmultiplier),
		scaledSize: new google.maps.Size(levelmultiplier*10, levelmultiplier*2)
	};
	var title = new google.maps.Marker({
    position: new google.maps.LatLng(distlat, distlng),
    map: map,
	  icon: iconImg
  });
	google.maps.event.addListener(title, 'click', function(event){
		if (!isNaN(1 * districtid)) {
			window.location.href = '/indicator.php?action=regionView&district=' + districtid;
		}
	});
}

function setRegionColor(section, color) {
	if (color) {
		strokeStyle.fillOpacity = 1;
	}
	if (!regions.length) {
		// convert to GeoJSON and add to Google Map if not done already
		regions = ['a'];
		var sectionids = [
			<?php foreach($results['districts'] as $dist) : ?>
				<?php foreach($regions[$dist['id']] as $reg) : ?>
					<?php foreach($sections[$reg['id']] as $sec) : ?>
<?php echo $sec['id']; ?>,
          <?php endforeach; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
			-1
		];
		sectionids.pop();
		return $.post("marker.php?page=sectionBorderMega", {
			ids: sectionids
		}, function (inregions) {
			regions = [];
			for (var ir = 0; ir < inregions.length; ir++) {
				var region = inregions[ir];
				var incoord = region.coordinate;
				var coordinates = [];
				for (var c = 0; c < incoord.length; c++) {
					incoord[c][0] *= 1;
					incoord[c][1] *= 1;
					if (isNaN(incoord[c][0]) || isNaN(incoord[c][1])) {
						continue;
					}
					coordinates.push([incoord[c][1], incoord[c][0]]);
				}
				if (!coordinates.length) {
					continue;
				}
				coordinates.push(coordinates[0]);

				regions.push({
					id: region.id,
					type: 'Feature',
					properties: {
						id: region.id,
		  			title: region.title,
			  		district_id: region.district_id,
					  region_id: region.region_id,
					  area: region.area
					},
					geometry: {
						type: 'Polygon',
					  coordinates: [coordinates]
					}
				});
			}
			map.data.addGeoJson({
				type: 'FeatureCollection',
				features: regions
			});
			setRegionColor(section, color);
		});
	}

	styleByRegion[section] = color;
	map.data.setStyle(function(feature) {
		return {
			strokeColor: strokeStyle.color,
			strokeOpacity: strokeStyle.opacity,
			strokeWeight: strokeStyle.weight,
			fillColor: styleByRegion[feature.getId()] || '#fff',
			// fill this region with the set color, unless no color exists or filling is off
			fillOpacity: ((strokeStyle.fillOpacity && styleByRegion[feature.getId()]) ? 0.6 : 0 )
		};
	});
}

function addDistrict(district, district_title) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addBorderDistrict&district='+district, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var districtCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				districtCoord.push(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			var district = new google.maps.Polygon({
				paths: districtCoord,
				strokeColor: '#FFFFFF',
				strokeOpacity: 1,
				strokeWeight: 2,
				fillColor: '#00a5d3',
				fillOpacity: 0.1,
				map: map,
				clickable: false
			});
			districts.push(district);
			google.maps.event.addListener(district, 'click', function(event){
				infoWindow.close();
				var contentString = '<div class="mapLinkBox"><a href="<?php echo SITE_URL; ?>indicator.php?action=regionView&district='+district+'"><strong>'+district_title+'</strong> дүүргийн газрын зураглалын сан руу шилжих</a></div>';
				infoWindow.setContent(contentString);
				infoWindow.setPosition(event.latLng);
				infoWindow.open(map);
			});
		}
	});
}

function addMarker(typeid) {
	if (markers[typeid] && markers[typeid].length) {
		for (var m = 0; m < markers[typeid].length; m++) {
			markers[typeid][m].setMap(map);
		}
		return;
	}
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addMarkerDistrict&type='+typeid, function(point){
		loadMarkers(point, typeid);
	});
}

function addWalk(type, district) {
	if(type == "walk-bus") {
		var walkid = 1;
	} else {
		var walkid = 2;
	}
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addMarkerDistrict&type='+walkid, function(point) {
		processWalkCircles(point, walkid);
	});
}
$(".chosen-select").chosen({no_results_text: "Хайлт олдсонгүй."});

$(".chosen-select").change(function(){ if ($(this).val()!='') { window.location.href=$(this).val(); } });

</script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize"></script>
