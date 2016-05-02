<style type="text/css">
.united-kingdom {
	background: #EEE;
	background-repeat: no-repeat;
}

.heaven-on-earth {
	fill: yellow;
}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div id="map" class="united-kingdom">
				<!-- Raphaël JS Map Here -->
			</div>
			<h3 id="region-name" style="background:#FC0; color:#FFF; font:sans-serif; text-transform:uppercase; margin-top:-15px; padding-left:30px"></h3>
		</div>  
		<div class="col-md-3">
			<div class="svg-box" id="svg-infobox">
				<div class="svg-box-title">
					Улаанбаатар хот
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER."icons/64/population.png"; ?>" class="img-responsive"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Нийт хүн ам
								</div>
								<div class="svg-info-num">
									<?php echo number_format($results['info']['population']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER."icons/64/area.png"; ?>" class="img-responsive"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Газар нутгийн хэмжээ
								</div>
								<div class="svg-info-num">
									<?php echo number_format($results['info']['area_length']).' га'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER."icons/64/household.png"; ?>" class="img-responsive"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Нийт өрхийн тоо
								</div>
								<div class="svg-info-num">
									<?php echo number_format($results['info']['household']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER."icons/64/pop-density.png"; ?>" class="img-responsive"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Хүн амын нягтаршил
								</div>
								<div class="svg-info-num">
									<?php echo number_format($results['info']['population_density']).' хүн/га'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/raphael-min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/map.js"></script>
