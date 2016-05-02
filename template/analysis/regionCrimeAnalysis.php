<?php
include(SITE_TEMPLATE. "header.php");
?>
<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/bg-orange3.jpg'; ?>" class="bg-page-image"/>
				<div class="page-report">
				
				<div class="reportBtnRow">
				<a class="reportBackBtn" href="<?php echo SITE_URL.'report.php?action=reportListBack&district='.$district['id'].'&region='.$region['id'].'&year='.$_GET['year']; ?>">
					<i class="glyphicon glyphicon-arrow-left"></i>
					<div>Буцах</div>
				</a>
				<a class="reportBtn" href="http://FreeHTMLtoPDF.com/?convert=http%3A%2F%2Fmanaikhoroo.ub.gov.mn%2Freport.php%3Faction%3DregionRiskReportPdf%26district=<?php echo $_GET['district']; ?>%26region=<?php echo $_GET['region']; ?>%26year=<?php echo $_GET['year']; ?>&size=A4&orientation=portrait&enablejs=1">
					<i class="glyphicon glyphicon-print"></i>
					<div>PDF хувилбар</div>
				</a>
				<a class="reportPrintBtn" href="javascript:window.print()">
					<i class="glyphicon glyphicon-print"></i>
					<div>Хэвлэх</div>
				</a>
				</div>
				<div class="reportMapLarge2">
					<div id="reportMapBox" style="height: 630px; width: 22cm;">
					</div>
					<div class="reportMapTitle">
						<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/maptitlebg.png'; ?>" class="mapTitleBg"/>
						<div class="mapTitleText">
						<?php echo $district['title'].' дүүргийн осол, гэмт хэрэг гадаг цэгүүд'; ?>
						</div>
					</div>
					<div class="reportDetailBox">
						<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/mapdetailbg.jpg'; ?>" class="mapDetailBg"/>
						<div class="reportDetailInfo">
							<div class="reportDetailTitle">
								Таних тэмдэг
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage2">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/crime-dot.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Осол, гэмт хэрэг гардаг цэг
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailSub">
									1000 хүнд ноогдох гэмт хэрэг, осол
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage5">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/small.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Бага
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage6">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/medium.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Дунд
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage7">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/large.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Их
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailSub">
									Хүн амын нягтаршил
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									<?php 
										echo number_format($breaks[1], 2).' - '.number_format($breaks[2],2);
									?>
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									<?php echo number_format($breaks[2]+0.01,2).' - '.number_format($breaks[3],2); ?>
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									<?php echo number_format($breaks[3]+0.01,2).' - '.number_format($from,2); ?>
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									<?php echo number_format($from+0.01,2).' - '.number_format($breaks[4],2); ?>
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/regionBorder.jpg"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Дүүргийн хил
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/sectionBorder.jpg"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Хорооны хил
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
<?php
	if(in_array($_GET['district'], array(1, 2))) {
?>
		zoom: <?php echo $region['zoom']+1; ?>,
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
	map = new google.maps.Map(document.getElementById('reportMapBox'),
      mapOptions);
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