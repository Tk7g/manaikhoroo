<?php
include(SITE_TEMPLATE. "header.php");
?>
<style type="text/css">
.profileTypeCol2 {
	width: 75%;
}

.profileTypeRow {
	border: 1px solid #000;
}

.profileTypeDetailTitle, .profileTypeDetailText, .profileTypeInfoNumber, .profileTypeInfoDesc {
	color: #333 !important;
}

.profileKhesegs li {
	float: left;
	width: 180px;
}

.profileKhesegs label {
	font-weight: bold;
}
</style>
<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<div class="page-report">
				<div class="reportBtnRow">
				<a class="reportBackBtn" href="<?php echo SITE_URL.'report.php?action=reportListBack&district='.$district['id'].'&region='.$region['id'].'&year='.$_GET['year']; ?>">
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
								<div class="profileKhesegs buses">
									<h4>Count by Kheseg</h4>
									<?php foreach($sections as $sec) : ?>
										<li class="kheseg">
										  <label><?php echo $sec['title']; ?>-P</label>
											<span class="<?php echo $sec['id'] ?>">0</span>
										</li>
									<?php endforeach; ?>
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
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/shared-report.js"></script>
<script>
var map;

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
	map = new google.maps.Map(document.getElementById('profileMainMap'), mapOptions);
	<?php foreach($regions as $reg) : ?>
	addRegion(<?php echo $district['id'] ?>, <?php echo $reg['id']; ?>, true);
	<?php endforeach; ?>

	<?php $secids = []; $densities = []; $titles = []; ?>
	<?php foreach($sections as $sec) : ?>
		<?php array_push($secids, $sec['id']);?>
		<?php array_push($titles, $sec['title']);?>
		<?php array_push($densities, $population_density[$sec['title']]);?>
	<?php endforeach; ?>
	addSections(<?php echo json_encode($secids); ?>, <?php echo json_encode($densities); ?>, map, 0.8, <?php echo json_encode($titles); ?>);
	//addSection(<?php echo $sec['id']; ?>, '<?php echo $kin_ratio[$sec['title']]; ?>', kindergardenMap, 0.5);

}
</script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize&libraries=geometry"></script>

<?php
include(SITE_TEMPLATE. "footer.php");
?>
