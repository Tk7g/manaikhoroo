<div class="marker-box-title">
	Тэмдэглэгээ
</div>
<div class="marker-box-home">
	<?php 
		$marker_groups = Marker::getMarkerGroups();
		$m = 0;
		foreach($marker_groups as $m_group) :
	?>
	<?php if($m_group['id'] == 12) { ?>
	<div class="markerGroupTab markerGroupTabSpecial" data="<?php echo $m_group['id']; ?>"><?php echo $m_group['title']; ?><i class="fa fa-angle-down"></i></div>
	<?php } else { ?>
	<div class="markerGroupTab" data="<?php echo $m_group['id']; ?>"><?php echo $m_group['title']; ?><i class="fa fa-angle-down"></i></div>	
	<?php } ?>
	<div class="markerGroupSection groupSection<?php echo $m_group['id']; ?>" data="0">
	<?php
			$type_markers[$m] = Marker::getGroupMarkers($m_group['id']);
			foreach($type_markers[$m] as $t_marker) :
	?>
	<div class="marker-row">
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
	</div>
	<?php if($t_marker['id'] == 1) { ?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="<?php echo IMG_FOLDER.'icons/25/walk-bus.png'; ?>" />
		</div>
		<div class="marker-checker-walk">
			<div class="marker-checkbox" data="walk-bus">
			</div>
			<div class="marker-checked" data="walk-bus">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Автобусны буудлаас 5 минутаас бага хугацаанд алхах зай
			</div>
		</div>
	</div>
	<?php 
		}
		if($t_marker['id'] == 2) {
	?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="<?php echo IMG_FOLDER.'icons/25/walk-water.png'; ?>" />
		</div>
		<div class="marker-checker-walk">
			<div class="marker-checkbox" data="walk-water">
			</div>
			<div class="marker-checked" data="walk-water">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Усны худгаас 5 минутаас бага хугацаанд алхах зай
			</div>
		</div>
	</div>
	<?php		
		}
			endforeach;
			if($m_group['id'] == 1) {
	?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/road.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="road-pol">
			</div>
			<div class="marker-checked" data="road-pol">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Төв зам
			</div>
		</div>
	</div>
	<?php
			} elseif($m_group['id'] == 4) {
	?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/flood.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="flood-pol">
			</div>
			<div class="marker-checked" data="flood-pol">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Үерийн аюултай бүс
			</div>
		</div>
	</div>
	<?php
			} elseif($m_group['id'] == 5) {
	?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/pl.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="pl-pol">
			</div>
			<div class="marker-checked" data="pl-pol">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Ногоон байгууламж
			</div>
		</div>
	</div>
	<?php			
			} elseif($m_group['id'] == 14) {
	?>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/niislel.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="niislelline">
			</div>
			<div class="marker-checked" data="niislelline">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Нийслэлийн нэгдсэн шугам
			</div>
		</div>
	</div>
	<!--<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/zhut.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="zhutline">
			</div>
			<div class="marker-checked" data="zhutline">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				ЗХУТ-ын шугам
			</div>
		</div>
	</div>-->
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/mobinet.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="cableline">
			</div>
			<div class="marker-checked" data="cableline">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Mobinet шугам
			</div>
		</div>
	</div>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/univision.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="uniline">
			</div>
			<div class="marker-checked" data="uniline">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Univision шугам
			</div>
		</div>
	</div>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/gmobile.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="gmobileline">
			</div>
			<div class="marker-checked" data="gmobileline">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Gmobile шугам
			</div>
		</div>
	</div>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/topnet.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="tnline">
			</div>
			<div class="marker-checked" data="tnline">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				TopNet шугам
			</div>
		</div>
	</div>
	<div class="marker-row">
		<div class="marker-image">
		<img src="http://manaikhoroo.ub.gov.mn/webroot/img/icons/25/magicnet.png" />
		</div>
		<div class="marker-checker">
			<div class="marker-checkbox" data="magicline">
			</div>
			<div class="marker-checked" data="magicline">
			</div>
		</div>
		<div class="marker-description">
			<div class="marker-title">
				Magicnet шугам
			</div>
		</div>
	</div>
	<?php
			}
			$m = $m + 1;
	?>
	</div>
	<?php
		endforeach;
	?>
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

<div class="marker-box-title5" style="background: #383838; text-align: center; color: #FFF; font-size: 13px; padding: 3px 10px;">
	Вэб статистик
</div>
<div class="marker-box-home">
<?php
$todayCount = Statistic::countTodayVisit();
$weekCount = Statistic::countWeekVisit();
$monthCount = Statistic::countMonthVisit();
$totalCount = Statistic::countAllVisit();
?>
	<div class="statCounter" style="font-size: 12px;"><?php echo '<span style="width: 100px; display: block; float: left;">Өнөөдөр:</span> '.$todayCount['COUNT(*)']; ?></div>
	<div class="statCounter" style="font-size: 12px;"><?php echo '<span style="width: 100px; display: block; float: left;">Энэ 7 хоногт:</span> '.$weekCount['COUNT(*)']; ?></div>
	<div class="statCounter" style="font-size: 12px;"><?php echo '<span style="width: 100px; display: block; float: left;">Энэ сард:</span> '.$monthCount['COUNT(*)']; ?></div>
	<div class="statCounter" style="font-size: 12px;"><?php echo '<span style="width: 100px; display: block; float: left;">Энэ жил:</span> '.$totalCount['COUNT(*)']; ?></div>
</div>

<script>
var tabOpen = 0;
$('.markerGroupTab').bind('click', function(e){
	var tabId = $(this).attr('data');
	if($('.groupSection'+tabId).attr('data') != 1) {
		$('.markerGroupSection').each(function(i){
			$(this).slideUp();
		});	
		$('.markerGroupTab').each(function(i){
			$(this).removeClass('markerGroupTabSelected');
		});	
		$('.groupSection'+tabId).slideDown();
		$('.groupSection'+tabId).attr('data', '1');
		$(this).addClass('markerGroupTabSelected');
	} else {
		$('.groupSection'+tabId).slideUp();
		$('.groupSection'+tabId).attr('data', '0');
		$(this).removeClass('markerGroupTabSelected');
	}
});
</script>