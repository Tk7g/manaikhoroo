<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include("session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/">Удирдлагын хэсэг</a>
	</li>
</ul>
<?php if ( isset( $result ) ) { ?>
	<div class="box-content status-message"><?php echo $result; ?></div>
<?php } ?>
<div class="row-fluid">
	<div class="row-title">
		<?php echo $results['data']['district_title'].' дүүргийн '.$results['data']['region_title'].'-р хорооны '.$results['year'].' оны мэдээлэл'; ?>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row-fluid row-admin">	
	<div class="quick-button metro yellow span2 info-box">
		<i class="icon-group"></i>
		<div class="info-block-desc">Хүн амын тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['population']); ?>
		</div>
	</div>
	<div class="quick-button metro red span2 info-box">
		<i class="icon-home"></i>
		<div class="info-block-desc">Нийт өрхийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['household']); ?>
		</div>
	</div>
	<div class="quick-button metro blue span2 info-box">
		<i class="icon-picture"></i>
		<div class="info-block-desc">Газар нутгийн хэмжээ</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['area_length']).' га'; ?>
		</div>
	</div>
	<div class="quick-button metro green span2 info-box">
		<i class="icon-th-large"></i>
		<div class="info-block-desc">Хүн амын нягтаршил</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['population_density']).' хүн/га'; ?>
		</div>
	</div>
	<div class="quick-button metro pink span2 info-box">
		<i class="icon-user"></i>
		<div class="info-block-desc">Өрхийн дундаж хэмжээ</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['household_average']); ?>
		</div>
	</div>
	
	<div class="clearfix"></div>
</div>
<div class="row-fluid row-admin">	
	<div class="quick-button metro black span2 info-box">
		<i class="icon-trash"></i>
		<div class="info-block-desc">Албан бус хогийн цэгийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['trash_num']); ?>
		</div>
	</div>
	<div class="quick-button metro greenDark span2 info-box">
		<i class="icon-warning-sign"></i>
		<div class="info-block-desc">Аюултай бүсээс 100 м зайнд амьдардаг хүн амын %</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['risk_ratio']).'%'; ?>
		</div>
	</div>
	<div class="quick-button metro yellow span2 info-box">
		<i class="icon-plus"></i>
		<div class="info-block-desc">Өрхийн болон бусад эмнэлэгийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['hospital_num']); ?>
		</div>
	</div>
	<div class="quick-button metro red span2 info-box">
		<i class="icon-warning-sign"></i>
		<div class="info-block-desc">2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['kin_num']); ?>
		</div>
	</div>
	<div class="quick-button metro blue span2 info-box">
		<i class="icon-flag"></i>
		<div class="info-block-desc">6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['data']['school_num']); ?>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<?php 
include(ADMIN_TEMPLATE. "charts/population-chart.php"); 
include(ADMIN_TEMPLATE. "charts/household-chart.php"); 
include(ADMIN_TEMPLATE. "charts/area-chart.php"); 
include(ADMIN_TEMPLATE. "charts/popdensity-chart.php"); 
include(MAIN_TEMPLATE. "footer.php"); 
?>