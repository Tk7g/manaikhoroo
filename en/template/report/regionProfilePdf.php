<?php
include(SITE_TEMPLATE. "header-report2.php");
?>
<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<div class="page-report">
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
										<?php echo number_format($info['area_length'],2); ?>
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
									<div class="profileTypeInfoNumber1">
										<?php echo $info['toron_garts'].'м'; ?>
									</div>
									<div class="profileTypeInfoDesc">
										Авто замын гарц гаргах боломжит газар
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
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/torongarts.png"; ?>" /> Торон гарц гаргах боломжит газар
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" />
									<?php 
										echo number_format($breaks[1], 2).' - '.number_format($breaks[2],2);
									?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" />
												<?php echo number_format($breaks[2]+0.01,2).' - '.number_format($breaks[3],2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" />
												<?php echo number_format($breaks[3]+0.01,2).' - '.number_format($from,2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" />
												<?php echo number_format($from+0.01,2).' - '.number_format($breaks[4],2); ?>
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
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/fieldIcon.png'; ?>" class="profileIconBg" />
						</div>
					</div>
					<div class="profileTypeCol2">
						<div class="profileTypeInfo">
							<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/schoolBg.jpg'; ?>" class="profileBg" />	
							<div class="profileTypeInfo">
								<div class="profileTypeDetail">
									<div class="profileTypeDetailTitle">Нийтийн эзэмшлийн зам талбай</div>
									<div class="profileTypeDetailText">
										Иргэдийн эрүүл мэнд болон амьдрах орчны нөхцөл байдлыг сайжруулах
									</div>
								</div>
								<div class="profileTypeInformation">
									<div class="profileTypeInfoNumber">
										<?php echo $info['pale_ground'].' м<sup>2</sup>'; ?>
									</div>
									<div class="profileTypeInfoDesc">
										Сул шороон хөрстэй талбай
									</div>
									<div class="profileTypeInfoNumber1">
										<?php echo $count_parking['COUNT(*)']; ?>
									</div>
									<div class="profileTypeInfoDesc">
										Автомашины ил зогсоол
									</div>
									<div class="profileTypeInfoNumber1">
										<?php 
											if($info == NULL) {
												echo 0;
											} else {
												echo number_format(($info['tot_kinnum']+$info['tot_schoolnum'])/$count_playground['COUNT(*)']); 
											}
										?>
									</div>
									<div class="profileTypeInfoDesc">
										Нэг тоглоомын талбайд ноогдох хүүхдийн тоо
									</div>
								</div>
								<div class="profileTypeMap">
									<div id="profileGroundMap" style="height: 170px; width: 160px;">
									</div>
								</div>
								<div class="profileTypeMapInfo">
									<div class="profileTypeMapTitle">
										Тэмдэглэгээ
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/playground.png"; ?>" /> <?php echo $playground['title']; ?>
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/parking.png"; ?>" /> <?php echo $parking['title']; ?>
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/garden.png"; ?>" /> Ногоон байгууламж болох боломжит газар
									</div>
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/road.png"; ?>" /> Засмал/Төв зам
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" />
									<?php 
										echo number_format($breaks[1], 2).' - '.number_format($breaks[2],2);
									?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" />
												<?php echo number_format($breaks[2]+0.01,2).' - '.number_format($breaks[3],2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" />
												<?php echo number_format($breaks[3]+0.01,2).' - '.number_format($from,2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" />
												<?php echo number_format($from+0.01,2).' - '.number_format($breaks[4],2); ?>
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
										<?php echo '- Хог ачилт сард '.$info['trash_collect'].' удаа'; ?>
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" />
									<?php 
										echo number_format($breaks[1], 2).' - '.number_format($breaks[2],2);
									?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" />
												<?php echo number_format($breaks[2]+0.01,2).' - '.number_format($breaks[3],2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" />
												<?php echo number_format($breaks[3]+0.01,2).' - '.number_format($from,2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" />
												<?php echo number_format($from+0.01,2).' - '.number_format($breaks[4],2); ?>
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
										<?php echo number_format($info['risk_ratio'],2).'%'; ?>
									</div>
									<div class="profileTypeInfoDesc">
										<?php echo 'Нийт хүн амын '.number_format($info['risk_ratio'],2).'% нь үерийн аюултай бүсэд амьдарч байна.'; ?>
									</div>
									<div class="profileTypeInfoNumber">
										<?php echo number_format($info['risk_area']).'м<sup>2</sup>'; ?>
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
									<div class="profileTypeMapIcon">
										<img src="<?php echo MAIN_FOLDER."/images/reportProfile/flood.png"; ?>" /> Үерийн аюултай бүс
									</div>
									<div class="profilePopDensity">
										<div class="profilePopDensityTitle">
											Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
										</div>
										<div class="profilePopDensityInfo">
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" />
									<?php 
										echo number_format($breaks[1], 2).' - '.number_format($breaks[2],2);
									?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" />
												<?php echo number_format($breaks[2]+0.01,2).' - '.number_format($breaks[3],2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" />
												<?php echo number_format($breaks[3]+0.01,2).' - '.number_format($from,2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" />
												<?php echo number_format($from+0.01,2).' - '.number_format($breaks[4],2); ?>
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
										<?php echo number_format(($count_hospital['COUNT(*)']/$info['population'])*1000, 2); ?>
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
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" />
									<?php 
										echo number_format($breaks[1], 2).' - '.number_format($breaks[2],2);
									?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" />
												<?php echo number_format($breaks[2]+0.01,2).' - '.number_format($breaks[3],2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" />
												<?php echo number_format($breaks[3]+0.01,2).' - '.number_format($from,2); ?>
											</div>
											<div class="profilePopDensityColor">
												<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" />
												<?php echo number_format($from+0.01,2).' - '.number_format($breaks[4],2); ?>
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

<script>
	var map;
	var busMap;
	var parkingMap;
	var playgroundMap;
	var kindergardenMap;
	var trashMap;
	var riskMap;
	var hospitalMap;
	var regionBus;
	var iconBus = [];
	var iconLight = [];
	var iconParking = [];
	var iconPlayground = [];
	var iconKindergarden = [];
	var iconTrash = [];
	var iconCrime = [];
	var iconHospital = [];
	var busCircle = [];
	
	<?php foreach($regions as $reg) : ?>
	var regionArea<?php echo $reg['id']; ?>;
	<?php endforeach; ?>
	
	<?php foreach($sections as $sec) : ?>
		var sectionCoord<?php echo $sec['id']; ?> = [];
	<?php endforeach; ?>
	
	<?php foreach($playgrounds as $pg) : ?>
		var playgroundCoord<?php echo $pg['id']; ?> = [];
	<?php endforeach; ?>
	
	<?php foreach($torongarts as $tr) : ?>
		var torongartsCoord<?php echo $tr['id']; ?> = [];
	<?php endforeach; ?>
	
	<?php foreach($risks as $rk) : ?>
		var risksCoord<?php echo $rk['id']; ?> = [];
	<?php endforeach; ?>
	
google.maps.event.addDomListener(window, 'load', initialize);

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
<?php
	if(in_array($_GET['district'], array(1, 2))) {
?>
		zoom: <?php echo $region['zoom']; ?>,
		center: new google.maps.LatLng(<?php echo $region['center']; ?>),
<?php } else { ?>
		zoom: 8,
		center: new google.maps.LatLng(47.918506, 106.917750),
<?php } ?>
		panControl: false,
		mapTypeControl: false,
		zoomControl: false,
		scaleControl: false,
		streetViewControl: false,
		mapTypeId: google.maps.MapTypeId.HYBRID
		
	};
	map = new google.maps.Map(document.getElementById('profileMainMap'),
      mapOptions);
	busMap = new google.maps.Map(document.getElementById('profileBusMap'),
      mapOptions1);
	playgroundMap = new google.maps.Map(document.getElementById('profileGroundMap'),
      mapOptions1);
	kindergardenMap = new google.maps.Map(document.getElementById('profileKindergardenMap'),
      mapOptions1);
	trashMap = new google.maps.Map(document.getElementById('profileTrashMap'),
      mapOptions1);
	riskMap = new google.maps.Map(document.getElementById('profileRiskMap'),
      mapOptions1);
	hospitalMap = new google.maps.Map(document.getElementById('profileHospitalMap'),
      mapOptions1);
	
busMap.set('styles', [
  {
    featureType: 'road',
    elementType: 'geometry',
    stylers: [
      { color: '#faf372' },
      { weight: 0.4 }
    ]
  }
]);

playgroundMap.set('styles', [
  {
    featureType: 'road',
    elementType: 'geometry',
    stylers: [
      { color: '#faf372' },
      { weight: 0.4 }
    ]
  }
]);

kindergardenMap.set('styles', [
  {
    featureType: 'road',
    elementType: 'geometry',
    stylers: [
      { color: '#faf372' },
      { weight: 0.4 }
    ]
  }
]);

trashMap.set('styles', [
  {
    featureType: 'road',
    elementType: 'geometry',
    stylers: [
      { color: '#faf372' },
      { weight: 0.4 }
    ]
  }
]);

riskMap.set('styles', [
  {
    featureType: 'road',
    elementType: 'geometry',
    stylers: [
      { color: '#faf372' },
      { weight: 0.4 }
    ]
  }
]);

hospitalMap.set('styles', [
  {
    featureType: 'road',
    elementType: 'geometry',
    stylers: [
      { color: '#faf372' },
      { weight: 0.4 }
    ]
  }
]);
	
	<?php foreach($regions as $reg) : ?>
	addRegion(<?php echo $district['id'] ?>, <?php echo $reg['id']; ?>);
	<?php endforeach; ?>
	<?php foreach($sections as $sec) : ?>
		<?php
			if($pop_color[$sec['title']] == "#FFFFFF") {
		?>
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', map, 0);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', busMap, 0);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', playgroundMap, 0);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', trashMap, 0);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', riskMap, 0);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', hospitalMap, 0);
		<?php
			} else {
		?>
		addSection1(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', map, 0.8, '<?php echo MAIN_FOLDER.'/img/section/'.$sec['title'].'.png'; ?>');
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', map, 0.8);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', busMap, 0.5);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', playgroundMap, 0.5);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', trashMap, 0.5);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', riskMap, 0.5);
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', hospitalMap, 0.5);
		<?php
			}
		?>
		<?php
			if($kin_color[$sec['title']] == "#FFFFFF") {
		?>
		addSection(<?php echo $sec['id']; ?>, '<?php echo $kin_color[$sec['title']]; ?>', kindergardenMap, 0);
		<?php
			} else {
		?>
		addSection(<?php echo $sec['id']; ?>, '<?php echo $kin_color[$sec['title']]; ?>', kindergardenMap, 0.5);
		<?php		
			}
		?>
	<?php endforeach; ?>
	<?php foreach($torongarts as $tr) : ?>
		addTorongarts(<?php echo $tr['id']; ?>, busMap);
	<?php endforeach; ?>
	<?php foreach($risks as $rk) : ?>
		addRisks(<?php echo $rk['id']; ?>, riskMap);
	<?php endforeach; ?>
	<?php foreach($playgrounds as $pg) : ?>
		addPlayground(<?php echo $pg['id']; ?>, playgroundMap);
	<?php endforeach; ?>
	addWalk(<?php echo $region['id']; ?>, "#075932", 100, 0.3, 1, busMap);
	addWalk(<?php echo $region['id']; ?>, "#000", 200, 0.24, 1, busMap);
	addWalk(<?php echo $region['id']; ?>, "#31b47c", 300, 0.2, 1, busMap);
	addWalk(<?php echo $region['id']; ?>, "#55e6a8", 400, 0.16, 1, busMap);
	addMarker(<?php echo $region['id']; ?>, 1, '<?php echo MAIN_FOLDER."/images/reportProfile/bus.jpg"; ?>', busMap, iconBus);
	addMarker1(<?php echo $region['id']; ?>, 7, '<?php echo MAIN_FOLDER."/images/reportProfile/light.png"; ?>', busMap, iconLight);

	addMarker(<?php echo $region['id']; ?>, 19, '<?php echo MAIN_FOLDER."/images/reportProfile/playground.png"; ?>', playgroundMap, iconPlayground);
	addMarker(<?php echo $region['id']; ?>, 20, '<?php echo MAIN_FOLDER."/images/reportProfile/parking.png"; ?>', playgroundMap, iconParking);
	
	addWalk(<?php echo $region['id']; ?>, "#075932", 100, 0.21, 3, kindergardenMap);
	addWalk(<?php echo $region['id']; ?>, "#000", 200, 0.20, 3, kindergardenMap);
	addWalk(<?php echo $region['id']; ?>, "#31b47c", 300, 0.19, 3, kindergardenMap);
	addWalk(<?php echo $region['id']; ?>, "#55e6a8", 400, 0.18, 3, kindergardenMap);
	addMarker(<?php echo $region['id']; ?>, 3, '<?php echo MAIN_FOLDER."/images/reportProfile/kindergarden.jpg"; ?>', kindergardenMap, iconKindergarden);
	
	addMarker(<?php echo $region['id']; ?>, 10, '<?php echo MAIN_FOLDER."/images/reportProfile/trash.png"; ?>', trashMap, iconTrash);
	addMarker(<?php echo $region['id']; ?>, 6, '<?php echo MAIN_FOLDER."/images/reportProfile/crime.png"; ?>', riskMap, iconCrime);
	
	addWalk(<?php echo $region['id']; ?>, "#075932", 100, 0.3, 9, hospitalMap);
	addWalk(<?php echo $region['id']; ?>, "#000", 200, 0.24, 9, hospitalMap);
	addWalk(<?php echo $region['id']; ?>, "#31b47c", 300, 0.2, 9, hospitalMap);
	addWalk(<?php echo $region['id']; ?>, "#55e6a8", 400, 0.16, 9, hospitalMap);
	addMarker(<?php echo $region['id']; ?>, 9, '<?php echo MAIN_FOLDER."/images/reportProfile/hos.png"; ?>', hospitalMap, iconHospital);
	
	fitBoundary(<?php echo $region['id']; ?>, map);
<?php
	if(!in_array($_GET['district'], array(1, 2))) {
?>
	fitBoundary(<?php echo $region['id']; ?>, busMap);
	fitBoundary(<?php echo $region['id']; ?>, playgroundMap);
	fitBoundary(<?php echo $region['id']; ?>, kindergardenMap);
	fitBoundary(<?php echo $region['id']; ?>, trashMap);
	fitBoundary(<?php echo $region['id']; ?>, riskMap);
	fitBoundary(<?php echo $region['id']; ?>, hospitalMap);
<?php } ?>
}

function addMarker1(region, type, image, mapVar, iconVar) {
	$.getJSON('<?php echo SITE_URL; ?>report.php?action=getRegionMarkers&type='+type+'&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var iconImg = {
				url: image,
   				size: new google.maps.Size(8, 8),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(4,4),
				scaledSize: new google.maps.Size(4, 4)
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

function addTorongarts(section, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=torongartsBorder&torongarts='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['torongartsCoord'+section] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['torongartsCoord'+section][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['torongartsArea'+section] = new google.maps.Polygon({
    			path: window['torongartsCoord'+section],
    			 strokeColor: '#440101',
    			 strokeOpacity: 1,
    			 strokeWeight: 2,
    			 fillColor: '#ac0707',
    			 fillOpacity: 0.7
  			});
			window['torongartsArea'+section].setMap(mapVar);
		}
	});
}

function addRisks(section, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=risksBorder&risks='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['risksCoord'+section] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['risksCoord'+section][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['risksArea'+section] = new google.maps.Polygon({
    			path: window['risksCoord'+section],
    			 strokeColor: '#440101',
    			 strokeOpacity: 1,
    			 strokeWeight: 2,
    			 fillColor: '#ac0707',
    			 fillOpacity: 0.7
  			});
			window['risksArea'+section].setMap(mapVar);
		}
	});
}

function addMarker(region, type, image, mapVar, iconVar) {
	$.getJSON('<?php echo SITE_URL; ?>report.php?action=getRegionMarkers&type='+type+'&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var iconImg = {
				url: image,
   				size: new google.maps.Size(26, 26),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(4,4),
				scaledSize: new google.maps.Size(8, 9)
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

function addWalk(region, color, radius, opacity, type, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>report.php?action=getRegionMarkers&type='+type+'&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.coordinate.length; k++) {
				busCircle[k] = new google.maps.Circle({
    				center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: mapVar,
					fillColor: color,
					radius: radius,
					strokeWeight: 0,
					fillOpacity: opacity
  				});
				busCircle[k].setMap(mapVar);
			}
		}
	});
}

function addPlayground(playground, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=playgroundBorder&playground='+playground, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['playgroundCoord'+playground] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['playgroundCoord'+playground][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['playgroundArea'+playground] = new google.maps.Polygon({
    			path: window['playgroundCoord'+playground],
    			 strokeColor: '#000000',
    			 strokeOpacity: 1,
    			 strokeWeight: 1,
    			 fillColor: '#7cc242',
    			 fillOpacity: 0.5
  			});
			window['playgroundArea'+playground].setMap(mapVar);
		}
	});
}

function addSection1(section, color, mapVar, opac, image) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=sectionBorder&section='+section, function(point){
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
    			 strokeOpacity: 1,
    			 strokeWeight: 1,
    			 fillColor: color,
    			 fillOpacity: opac
  			});
  			var iconImg = {
				url: image,
   				size: new google.maps.Size(30, 30),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(14,13),
				scaledSize: new google.maps.Size(20, 20)
			}
			var regionImage = {url: image};
			var regionImagePosition = getCenterOfPolygon(window['sectionArea'+section]);
			var regionName = new google.maps.Marker({
      			position: regionImagePosition,
      			map: map,
      			icon: iconImg
  			});
			window['sectionArea'+section].setMap(mapVar);
		}
	});
}

function addSection(section, color, mapVar, opac) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=sectionBorder&section='+section, function(point){
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
    			 strokeOpacity: 1,
    			 strokeWeight: 1,
    			 fillColor: color,
    			 fillOpacity: opac
  			});
			window['sectionArea'+section].setMap(mapVar);
		}
	});
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

function getCenterOfPolygon(polygon){
	var PI=22/7
	var X=0;
	var Y=0;
	var Z=0;
	polygon.getPath().forEach(function (vertex, inex) {
		lat1=vertex.lat();
		lon1=vertex.lng();
		lat1 = lat1 * PI/180
		lon1 = lon1 * PI/180
		X += Math.cos(lat1) * Math.cos(lon1)
		Y += Math.cos(lat1) * Math.sin(lon1)
		Z += Math.sin(lat1)
	})
	Lon = Math.atan2(Y, X)
	Hyp = Math.sqrt(X * X + Y * Y)
	Lat = Math.atan2(Z, Hyp)
	Lat = Lat * 180/PI
	Lon = Lon * 180/PI 
	return new google.maps.LatLng(Lat,Lon);
}


$(document).ready(function(){
	$(".profileHeaderSub").delay(18000).fadeIn();	
});


</script>

<?php
include(SITE_TEMPLATE. "footer-report2.php");
?>