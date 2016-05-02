<?php
require_once(realpath(dirname(__FILE__))."/classes/Info.class.php");
require(realpath(dirname(__FILE__))."/config/settings.php");
$results = Info::singleRegionInfo($_POST['region_id']);
?>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="detail-infobox detail-blue">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/population.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district_title'].' '.$results['region_title'].'-р хороо'; ?>
						</div>
						<div class="detail-description">
							Хүн амын тоо
						</div>
						<div class="detail-number">
							<?php echo number_format($results['population']); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-darkgreen">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/household.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district_title'].' '.$results['region_title'].'-р хороо'; ?>
						</div>
						<div class="detail-description">
							Нийт өрхийн тоо
						</div>
						<div class="detail-number">
							<?php echo number_format($results['household']); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-green">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/school.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district_title'].' '.$results['region_title'].'-р хороо'; ?>
						</div>
						<div class="detail-description">
							Сургуульд хамрагддаггүй хүүхдийн тоо
						</div>
						<div class="detail-number">
							<?php echo number_format($results['school_num']); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="detail-infobox detail-yellow">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/area.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district_title'].' '.$results['region_title'].'-р хороо'; ?>
						</div>
						<div class="detail-description">
							Газар нутгийн хэмжээ
						</div>
						<div class="detail-number">
							<?php echo number_format($results['area_length']); ?> га
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-orange">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/pop-density.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district_title'].' '.$results['region_title'].'-р хороо'; ?>
						</div>
						<div class="detail-description">
							Хүн амын нягтаршил
						</div>
						<div class="detail-number">
							<?php echo number_format($results['population_density'], 2); ?> хүн/га
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-red">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/hospital.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district_title'].' '.$results['region_title'].'-р хороо'; ?>
						</div>
						<div class="detail-description">
							Өрхийн болон бусад эмнэлгийн тоо
						</div>
						<div class="detail-number">
							<?php echo number_format($results['hospital_num']); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>