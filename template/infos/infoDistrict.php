<div class="svg-box-title">
					<?php echo $results['district_title']; ?>
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
									<?php echo number_format($results['population']); ?>
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
									<?php echo number_format($results['area_length']).' га'; ?>
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
									<?php echo number_format($results['household']); ?>
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
									<?php echo number_format($results['population_density']).' хүн/га'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>