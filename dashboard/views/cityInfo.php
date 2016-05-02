<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include("session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/index.php?action=home">Удирдлагын хэсэг</a>
	</li>
</ul>
<?php if ( isset( $result ) ) { ?>
	<div class="box-content status-message"><?php echo $result; ?></div>
<?php } ?>
<div class="row-fluid">
	<div class="row-title">
		<?php echo 'Нийслэлийн '.$results['year'].' оны мэдээлэл'; ?>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row-fluid row-admin">	
	<div class="quick-button metro yellow span2 info-box">
		<i class="icon-group"></i>
		<div class="info-block-desc">Хүн амын тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['population']); ?>
		</div>
	</div>
	<div class="quick-button metro red span2 info-box">
		<i class="icon-home"></i>
		<div class="info-block-desc">Нийт өрхийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['household']); ?>
		</div>
	</div>
	<div class="quick-button metro blue span2 info-box">
		<i class="icon-picture"></i>
		<div class="info-block-desc">Газар нутгийн хэмжээ</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['area_length']).' га'; ?>
		</div>
	</div>
	<div class="quick-button metro green span2 info-box">
		<i class="icon-th-large"></i>
		<div class="info-block-desc">Хүн амын нягтаршил</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['population_density']).' хүн/га'; ?>
		</div>
	</div>
	<div class="quick-button metro pink span2 info-box">
		<i class="icon-user"></i>
		<div class="info-block-desc">Өрхийн дундаж хэмжээ</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['household_average']); ?>
		</div>
	</div>
	
	<div class="clearfix"></div>
</div>
<div class="row-fluid row-admin">	
	<div class="quick-button metro black span2 info-box">
		<i class="icon-trash"></i>
		<div class="info-block-desc">Албан бус хогийн цэгийн тоо</div>
		<div class="info-block-info">
<?php 

?>
		</div>
	</div>
	<div class="quick-button metro greenDark span2 info-box">
		<i class="icon-warning-sign"></i>
		<div class="info-block-desc">Аюултай бүсээс 100 м зайнд амьдардаг хүн амын %</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['risk_ratio']).'%'; ?>
		</div>
	</div>
	<div class="quick-button metro yellow span2 info-box">
		<i class="icon-plus"></i>
		<div class="info-block-desc">Өрхийн болон бусад эмнэлэгийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['hospital_num']); ?>
		</div>
	</div>
	<div class="quick-button metro red span2 info-box">
		<i class="icon-warning-sign"></i>
		<div class="info-block-desc">2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['kin_num']); ?>
		</div>
	</div>
	<div class="quick-button metro blue span2 info-box">
		<i class="icon-flag"></i>
		<div class="info-block-desc">6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо</div>
		<div class="info-block-info">
			<?php echo number_format($results['info']['school_num']); ?>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row-fluid">
	<div class="box span5" onTablet="span5" onDesktop="span5">
		<div class="box-header">
			<h2><i class="halflings-icon list"></i><span class="break"></span>Сүүлд оруулсан тоон мэдээлэл</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<ul class="dashboard-list">
			<?php foreach($latest_infos as $latest_info) : ?>
				<li>
					<a href="#">
						<i class="icon-file red"></i>                               
						<span class="blue"><?php echo substr($latest_info['created'], 0, 10) ?></span>
						<?php echo $latest_info['district'].' дүүргийн '.$latest_info['region'].'-р хорооны мэдээлэл орсон.'; ?>                                  
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="box span5" onTablet="span5" onDesktop="span5">
		<div class="box-header">
			<h2><i class="halflings-icon user"></i><span class="break"></span>Сүүлд оруулсан зурган тэмдэглэгээ</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<ul class="dashboard-list">
			<?php foreach($latest_markers as $lm) : ?>
				<li>
					<a href="#">
						<img src="<?php echo $lm['type_image']; ?>" class="avatar" alt="<?php echo $lm['type_title']; ?>"/>
					</a>
					<span class="label label-inverse"><strong>Төрөл:</strong> <?php echo $lm['type_title']; ?></span><br>
					<span class="label label-important"><strong>Огноо:</strong> <?php echo $lm['created']; ?></span><br>
					<span class="label label-inverse"><strong>Хороо:</strong> <?php echo $lm['district'].' дүүргийн '.$lm['region'].'-р хороо'; ?></span>                                  
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="box span5" onTablet="span5" onDesktop="span5">
		<div class="box-header">
			<h2><i class="halflings-icon list"></i><span class="break"></span>Сайтад хандсан хэрэглэгчдийн мэдээлэл</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<script type="text/javascript" src="http://feedjit.com/serve/?vv=1515&amp;tft=3&amp;dd=0&amp;wid=&amp;pid=0&amp;proid=0&amp;bc=FFFFFF&amp;tc=000000&amp;brd1=012B6B&amp;lnk=135D9E&amp;hc=FFFFFF&amp;hfc=2853A8&amp;btn=C99700&amp;ww=300&amp;wne=10&amp;srefs=0"></script><noscript><a href="http://feedjit.com/">Live Traffic Stats</a></noscript>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>