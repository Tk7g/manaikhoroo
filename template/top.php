<?php
	$info_city = new Info(); 
	$results = $info_city->getCityInfo(); 
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="ib-title">
				Улаанбаатар хотын ерөнхий үзүүлэлтүүд
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/population.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Хүн амын тоо</span>
				</div>
				<div class="info-number box-blue">
					<span><?php echo number_format($results['info']['population']); ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/household.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Өрхийн тоо</span>
				</div>
				<div class="info-number box-green">
					<span><?php echo number_format($results['info']['household']); ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/area.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Газар нутгийн хэмжээ</span>
				</div>
				<div class="info-number box-light-blue">
					<span><?php echo number_format($results['info']['area_length']).' га'; ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/household2.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Өрхийн дундаж хэмжээ</span>
				</div>
				<div class="info-number box-green">
					<span><?php echo number_format($results['info']['household_average']); ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/pop-density.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Хүн амын нягтаршил</span>
				</div>
				<div class="info-number box-blue">
					<span><?php echo number_format($results['info']['population_density']).' хүн/га'; ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/bus.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Автобусны буудлаас 5 мин алхах зайд оршдог хүн амын %</span>
				</div>
				<div class="info-number box-light-blue">
					<span><?php echo number_format($results['info']['bus_density']).' %'; ?></span>
				</div>
			</div>
		</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>Цэцэрлэгт хамрагддаг- гүй хүүхдийн эзлэх %</span>
				</div>
				<div class="info-number box-green">
					<span><?php echo number_format($results['info']['kin_ratio']).' %'; ?></span>
				</div>
			</div>
			<div class="image-box2">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/kindergarden.png'; ?>" class="img-responsive"/>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>Сургуульд хамрагддаг- гүй хүүхдийн эзлэх %</span>
				</div>
				<div class="info-number box-blue">
					<span><?php echo number_format($results['info']['school_ratio']).' %'; ?></span>
				</div>
			</div>
			<div class="image-box2">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/school.png'; ?>" class="img-responsive"/>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>Аюултай бүсээс 100м зайд оршдог хүн амын %</span>
				</div>
				<div class="info-number box-red">
					<span><?php echo number_format($results['info']['risk_ratio']).' %'; ?></span>
				</div>
			</div>
			<div class="image-box2">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/risk.png'; ?>" class="img-responsive"/>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>Өрхийн болон бусад эмнэлгийн тоо</span>
				</div>
				<div class="info-number box-light-blue">
					<span><?php echo number_format($results['info']['hospital_num']); ?></span>
				</div>
			</div>
			<div class="image-box2">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/hospital.png'; ?>" class="img-responsive"/>
			</div>
		</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
			<div class="info-block">
				<div class="info-box info-box2">
					<div class="info-ttl">
						<span>Албан бус хогийн цэгийн тоо</span>
					</div>
					<div class="info-number box-red">
						<span><?php echo number_format($results['info']['trash_num']); ?></span>
					</div>
				</div>
				<div class="image-box2">
					<img src="<?php echo MAIN_FOLDER.'/img/icons/98/trash.png'; ?>" class="img-responsive"/>
				</div>
			</div>
		</div>
		<div class="col-md-2 col-xs-4 col-md-4">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>1000 хүнд ноогдох усны худгийн тоо</span>
				</div>
				<div class="info-number box-blue">
					<span><?php echo number_format($results['info']['well_density']); ?></span>
				</div>
			</div>
			<div class="image-box2">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/well.png'; ?>" class="img-responsive"/>
			</div>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$(".info-block").hover(function(){
			$(this).find(".info-number").slideToggle("slow");
		});
	});
</script>