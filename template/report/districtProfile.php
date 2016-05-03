<?php
include(SITE_TEMPLATE. "header.php");
?>
<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<div class="page-report">
				<div class="reportBtnRow">
				<a class="reportBackBtn" href="<?php echo SITE_URL.'report.php?action=reportDistrictListBack&district='.$district['id'].'&year='.$_GET['year']; ?>">
					<i class="glyphicon glyphicon-arrow-left"></i>
					<div>Буцах</div>
				</a>
				<a class="reportPrintBtn" href="javascript:window.print()">
					<i class="glyphicon glyphicon-print"></i>
					<div>Хэвлэх</div>
				</a>
				</div>
				<div class="profileHeader">
					<div class="profileCol1">
						<div class="profileHeaderSub">
							дүүрэг
						</div>
						<div class="profileHeaderTitle">
							<?php echo $district['title']; ?>
						</div>
					</div>
					<div class="profileCol2">
						<div class="profileHeaderSub">
							Нийт иргэдийн тоо
						</div>
						<div class="profileHeaderInfo">
							<?php echo number_format($info['population']); ?>
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
					<div class="profileCol2">
						<div class="profileTopInfo">
							<div class="profileTopCol">
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['household']); ?>
									</div>
									<div class="profileTopSub">
										Нийт өрхийн тоо
									</div>
								</div>
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['household_average'], 2); ?>
									</div>
									<div class="profileTopSub">
										Нэг өрхийн гишүүдийн дундаж тоо
									</div>
								</div>
							</div>
							<div class="profileTopCol">
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['area_length']); ?>
									</div>
									<div class="profileTopSub">
										Газар нутгийн хэмжээ /га/
									</div>
								</div>
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['population_density'], 2); ?>
									</div>
									<div class="profileTopSub">
										Хүн амын нягтаршил /1 га/
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="profileTypeRow">
					<div class="profileTypeCol1">
						<div class="profileIcon">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/busIcon.jpg'; ?>" class="profileIconBg" />
						</div>
					</div>
					<div class="profileTypeCol2">
						<div class="profileTypeInfo">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/busBg.jpg'; ?>" class="profileBg" />
							<div class="profileTypeInfo">
								<div class="profileTypeDetail">
									<div class="profileTypeDetailTitle">Нийтийн тээвэр, торон гарц</div>
									<div class="profileTypeDetailText">
										Автобусны буудалтай ойр байснаар иргэд нийтийн тээврийн үйлчилгээг ашиглан ажилдаа ирж очих ба өөр бусад төрлийн үйлчилгээг авах боломжоор хангагдана.
									</div>
								</div>
								<div class="profileTypeInformation">
									<div class="profileTypeInfoNumber">
										<?php echo $info['bus_density'].'%'; ?>
									</div>
									<div class="profileTypeInfoDesc">
										<?php echo 'Хүн амын '.$info['bus_density'].'% нь автобусны буудлаас 5 минут алхах зайнд амьдардаг.'; ?>
									</div>
								</div>
								<div class="profileTypeMap">
									<div id="profileBusMap" style="height: 170px; width: 160px;">
									</div>
								</div>
								<div class="profileTypeMapInfo">
									<div class="profileTypeMapTitle">
										Тэмдэглэгээ
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/bus.jpg"; ?>" /> <?php echo $bus['title']; ?>
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo $light['image']; ?>" /> <?php echo $light['title']; ?>
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" /> 1 - 50
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" /> 51 - 100
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" /> 101 - 200
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" /> 201 >
											</div>
										</div>
										<div class="profileBusWalk">
											<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/bus-walk.png'; ?>" /> 5 минутанд алхах зай
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="profileTypeRow">
					<div class="profileTypeCol1">
						<div class="profileIcon">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/schoolIcon.jpg'; ?>" class="profileIconBg" />
						</div>
					</div>
					<div class="profileTypeCol2">
						<div class="profileTypeInfo">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/schoolBg.jpg'; ?>" class="profileBg" />
							<div class="profileTypeInfo">
								<div class="profileTypeDetail">
									<div class="profileTypeDetailTitle">Сургуулийн насны боловсрол</div>
									<div class="profileTypeDetailText">
										<?php echo '6-16 насны '.$info['school_num'].' буюу энэ насны ангилалын нийт хүүхдийн '.number_format($info['school_ratio'],1).'% нь сургуульд хамрагдаагүй байна.'; ?>
									</div>
								</div>
								<div class="profileTypeInformation">
									<div class="profileTypeInfoNumber">
										<?php echo number_format($info['school_ratio'],1).'%'; ?>
									</div>
									<div class="profileTypeInfoDesc">
										<?php echo '6-16 насны хүүхдийн '.number_format($info['school_ratio'],1).'% нь сургуульд хамрагддаггүй.'; ?>
									</div>
								</div>
								<div class="profileTypeMap">
									<div id="profileSchoolMap" style="height: 170px; width: 160px;">
									</div>
								</div>
								<div class="profileTypeMapInfo">
									<div class="profileTypeMapTitle">
										Тэмдэглэгээ
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/school.jpg"; ?>" /> <?php echo $school['title']; ?>
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Сургуульд хамрагдаагүй 6-16 насны хүүхдийн тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" /> 1 - 50
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" /> 51 - 100
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" /> 101 - 200
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" /> 201 >
											</div>
										</div>
										<div class="profileBusWalk">
											<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/bus-walk.png'; ?>" /> 5 минутанд алхах зай
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="profileTypeRow">
					<div class="profileTypeCol1">
						<div class="profileIcon">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/kinIcon.jpg'; ?>" class="profileIconBg" />
						</div>
					</div>
					<div class="profileTypeCol2">
						<div class="profileTypeInfo">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/kinBg.jpg'; ?>" class="profileBg" />
							<div class="profileTypeInfo">
								<div class="profileTypeDetail">
									<div class="profileTypeDetailTitle">Сургуулийн өмнөх насны боловсрол</div>
									<div class="profileTypeDetailText">
										<?php echo '2-5 насны '.$info['kin_num'].' буюу энэ насны ангилалын нийт хүүхдийн '.number_format($info['kin_ratio'],1).'% нь сургуульд хамрагдаагүй байна. Энэ нь эдгээр хүүхдүүдийг цаашид сургуульд сайн суралцахад сөргөөр нөлөөлнө.'; ?>
									</div>
								</div>
								<div class="profileTypeInformation">
									<div class="profileTypeInfoNumber">
										<?php echo number_format($info['kin_ratio'],1).'%'; ?>
									</div>
									<div class="profileTypeInfoDesc">
										<?php echo '2-5 насны хүүхдийн '.number_format($info['kin_ratio'],1).'% нь цэцэрлэгт хамрагддаггүй.'; ?>
									</div>
								</div>
								<div class="profileTypeMap">
									<div id="profileKindergardenMap" style="height: 170px; width: 160px;">
									</div>
								</div>
								<div class="profileTypeMapInfo">
									<div class="profileTypeMapTitle">
										Тэмдэглэгээ
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/kindergarden.jpg"; ?>" /> <?php echo $kindergarden['title']; ?>
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Цэцэрлэгт хамрагдаагүй 2-5 насны хүүхдийн тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" /> 1 - 50
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" /> 51 - 100
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" /> 101 - 200
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" /> 201 >
											</div>
										</div>
										<div class="profileBusWalk">
											<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/bus-walk.png'; ?>" /> 5 минутанд алхах зай
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="profileTypeRow">
					<div class="profileTypeCol1">
						<div class="profileIcon">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/trashIcon.jpg'; ?>" class="profileIconBg" />
						</div>
					</div>
					<div class="profileTypeCol2">
						<div class="profileTypeInfo">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/trashBg.jpg'; ?>" class="profileBg" />
							<div class="profileTypeInfo">
								<div class="profileTypeDetail">
									<div class="profileTypeDetailTitle">Хог хаягдал</div>
									<div class="profileTypeDetailText">
										Хог хаягдлыг зориулалтын бусаар авах нь хорооны өнгө үзэмжинд сөргөөр нөлөөлөөд зогсохгүй халдварт өвчин үүсгэх аюултай.
									</div>
								</div>
								<div class="profileTypeInformation">
									<div class="profileTypeInfoNumber">
										<?php echo $trash_count['COUNT(*)']; ?>
									</div>
									<div class="profileTypeInfoDesc">
										Албан бус хогийн цэг
									</div>
								</div>
								<div class="profileTypeMap">
									<div id="profileTrashMap" style="height: 170px; width: 160px;">
									</div>
								</div>
								<div class="profileTypeMapInfo">
									<div class="profileTypeMapTitle">
										Тэмдэглэгээ
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/trash.png"; ?>" /> <?php echo $trash['title']; ?>
									</div>
									<div class="profileTypeMapIcon2">
										<?php echo '- Хог ачилт сард дунджаар  '.$info['trash_collect'].' удаа'; ?>
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" /> 1 - 50
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" /> 51 - 100
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" /> 101 - 200
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" /> 201 >
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="profileTypeRow">
					<div class="profileTypeCol1">
						<div class="profileIcon">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/riskIcon.jpg'; ?>" class="profileIconBg" />
						</div>
					</div>
					<div class="profileTypeCol2">
						<div class="profileTypeInfo">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/riskBg.jpg'; ?>" class="profileBg" />
							<div class="profileTypeInfo">
								<div class="profileTypeDetail">
									<div class="profileTypeDetailTitle">Аюултай бүс</div>
									<div class="profileTypeDetailText">
										Борооны улиралд жалга даган орж ирэх үерийн ус нь иргэд, оршин суугчдад маш их гарз хохирол учруулдаг. Эдгээр аюултай бүсүүдэд хог хаягдал ихээр овоорсоор байна.
									</div>
								</div>
								<div class="profileTypeInformation">
									<div class="profileTypeInfoNumber">
										<?php echo number_format($info['risk_ratio'],1).'%'; ?>
									</div>
									<div class="profileTypeInfoDesc">
										<?php echo 'Нийт хүн амын '.number_format($info['risk_ratio'],1).'% нь үерийн аюултай бүсэд амьдарч байна.'; ?>
									</div>
								</div>
								<div class="profileTypeMap">
									<div id="profileRiskMap" style="height: 170px; width: 160px;">
									</div>
								</div>
								<div class="profileTypeMapInfo">
									<div class="profileTypeMapTitle">
										Тэмдэглэгээ
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/crime.png"; ?>" /> Гэмт хэрэг гарах магадлал өндөр цэг
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" /> 1 - 50
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" /> 51 - 100
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" /> 101 - 200
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" /> 201 >
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="profileTypeRow">
					<div class="profileTypeCol1">
						<div class="profileIcon">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/hosIcon.jpg'; ?>" class="profileIconBg" />
						</div>
					</div>
					<div class="profileTypeCol2">
						<div class="profileTypeInfo">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/hosBg.jpg'; ?>" class="profileBg" />
							<div class="profileTypeInfo">
								<div class="profileTypeDetail">
									<div class="profileTypeDetailTitle">Өрхийн болон бусад эмнэлэг</div>
									<div class="profileTypeDetailText">
										Эрүүл мэндийн үйлчилгээний хүртээмжтэй байдал нь иргэдийн сайн сайхан амьдрах боломжийг бүрдүүлнэ.
									</div>
								</div>
								<div class="profileTypeInformation">
									<div class="profileTypeInfoNumber">
										<?php echo number_format(($hospital_count['COUNT(*)']/$info['population'])*1000,2); ?>
									</div>
									<div class="profileTypeInfoDesc">
										1000 хүнд ноогдох эрүүл мэндийн үйлчилгээний төв
									</div>
								</div>
								<div class="profileTypeMap">
									<div id="profileHospitalMap" style="height: 170px; width: 160px;">
									</div>
								</div>
								<div class="profileTypeMapInfo">
									<div class="profileTypeMapTitle">
										Тэмдэглэгээ
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/hos.png"; ?>" /> <?php echo $hospital['title']; ?>
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" /> 1 - 50
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" /> 51 - 100
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" /> 101 - 200
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" /> 201 >
											</div>
										</div>
										<div class="profileBusWalk">
											<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/bus-walk.png'; ?>" /> 5 минутанд алхах зай
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
	</div>
</div>

<script type="text/javascript" src="/webroot/js/jsts.min.js"></script>
<script type="text/javascript" src="/webroot/js/shared-report.js"></script>
<script>
	var map;
	var busMap;
	var schoolMap;
	var kindergardenMap;
	var trashMap;
	var riskMap;
	var hospitalMap;
	var regionBus;
	var busCircle = [];

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
	var mapOptions1 = {
		zoom: <?php echo $district['report_zoom']; ?>,
		center: new google.maps.LatLng(<?php echo $district['report_center'] ?>),
		panControl: false,
		mapTypeControl: false,
		zoomControl: false,
		scaleControl: false,
		streetViewControl: false,
		mapTypeId: google.maps.MapTypeId.HYBRID

	};

	map = new google.maps.Map(document.getElementById('profileMainMap'),
      mapOptions);

	<?php foreach($districts as $dist) : ?>
		 addDistrict(<?php echo $dist['id']; ?>);
	<?php endforeach; ?>
}

function addDistrict(district) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addBorderDistrict&district='+district, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var districtCoord = [];
			var bounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				var pt = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				districtCoord.push(pt);
				bounds.extend(pt);
			}
			new google.maps.Polygon({
				paths: districtCoord,
				strokeColor: '#000',
				strokeOpacity: 1,
				strokeWeight: 2,
				fillColor: '#f7c567',
				fillOpacity: 1,
				map: map
			});
			map.fitBounds(bounds);
		}
	});
}

function addWalk(region, color, radius, opacity, type, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getMarkers&type='+type+'&district='+region, function(point){

	});
}

function addMarker(region, type, image, mapVar, iconVar) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getMarkers&type='+type+'&district='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var iconImg = {
				url: image,
   				size: new google.maps.Size(26, 26),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(4,4),
				scaledSize: new google.maps.Size(5, 6)
			}
			for(var k = 0; k < point.coordinate.length; k++) {
				iconVar[k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: mapVar,
					icon: iconImg,
  				});
				iconVar[k].setMap(mapVar);
			}
		}
	});
}

function addRegion(section, color, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['regionCoord'+section] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['regionCoord'+section][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['regionArea'+section] = new google.maps.Polygon({
    			path: window['regionCoord'+section],
    			 strokeColor: '#000000',
    			 strokeOpacity: 1,
    			 strokeWeight: 1,
    			 fillColor: color,
    			 fillOpacity: 0.5
  			});
			window['regionArea'+section].setMap(mapVar);
		}
	});
}
</script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize&libraries=geometry"></script>

<?php
include(SITE_TEMPLATE. "footer.php");
?>
