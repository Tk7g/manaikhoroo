<?php
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Info.class.php");
require_once(realpath(dirname(__FILE__))."/classes/District.class.php");

$info = new Info;
$district_info = $info->getDistrictInfo($_GET['district']);
$district_title = District::getDistrict($_GET['district']);
?>
				<div class="svg-box-title">
				<?php echo $district_title['title']; ?>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER.'icons/64/population.png'; ?>"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Нийт хүн ам
								</div>
								<div class="svg-info-num">
									<?php echo number_format($district_info['district_data']['population']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER.'icons/64/area.png'; ?>"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Газар нутгийн хэмжээ
								</div>
								<div class="svg-info-num">
									<?php echo number_format($district_info['district_data']['area_length']).' га'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER.'icons/64/household.png'; ?>"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Нийт өрхийн тоо
								</div>
								<div class="svg-info-num">
									<?php echo number_format($district_info['district_data']['household']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="svg-box-info">
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo IMG_FOLDER.'icons/64/pop-density.png'; ?>"/>
						</div>
						<div class="col-md-8">
							<div class="svg-info">
								<div class="svg-info-ttl">
									Хүн амын нягтаршил
								</div>
								<div class="svg-info-num">
									<?php echo number_format($district_info['district_data']['population_density']).' хүн/га'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>