<?php
	$info_city = new Info(); 
	$results = $info_city->getCityInfo(); 
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="ib-title">
				Main indicators of Ulaanbaatar city
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/population.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Population</span>
				</div>
				<div class="info-number box-blue">
					<span><?php echo number_format($results['info']['population']); ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/household.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Total Household</span>
				</div>
				<div class="info-number box-green">
					<span><?php echo number_format($results['info']['household']); ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/area.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Total Area</span>
				</div>
				<div class="info-number box-light-blue">
					<span><?php echo number_format($results['info']['area_length']).' ha'; ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/household2.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Average Person per Household</span>
				</div>
				<div class="info-number box-green">
					<span><?php echo number_format($results['info']['household_average']); ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/pop-density.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Population Density</span>
				</div>
				<div class="info-number box-blue">
					<span><?php echo number_format($results['info']['population_density']).' per/ha'; ?></span>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-2">
		<div class="info-block">
			<div class="image-box">
				<img src="<?php echo MAIN_FOLDER.'/img/icons/98/bus.png'; ?>" class="img-responsive"/>
			</div>
			<div class="info-box">
				<div class="info-ttl">
					<span>Bus Stop <5 min walk &</span>
				</div>
				<div class="info-number box-light-blue">
					<span><?php echo number_format($results['info']['bus_density']).' %'; ?></span>
				</div>
			</div>
		</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>Absent from Kindergartens &</span>
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
		<div class="col-md-2">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>Absent from Schools %</span>
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
		<div class="col-md-2">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>People who live within 100m of area of risk %</span>
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
		<div class="col-md-2">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>Number of health clinics</span>
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
		<div class="col-md-2">
			<div class="info-block">
				<div class="info-box info-box2">
					<div class="info-ttl">
						<span>Number of illegal trash dump sites</span>
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
		<div class="col-md-2">
		<div class="info-block">
			<div class="info-box info-box2">
				<div class="info-ttl">
					<span>Water kiosks per 1000 people</span>
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