<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php">Зурган тэмдэглэгээ</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>Зурган тэмдэглэгээ</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<a href="?action=select" class='quick-button-small span2'><i class="icon-map-marker"></i><p>Зурган тэмдэглэгээ нэмэх</p></a>
			<a href="?action=delselect" class='quick-button-small span2'><i class="icon-trash"></i><p>Зурган тэмдэглэгээ устгах</p></a>
			<div class="clearfix"></div>
		</div>
		<div class="box-content">
			<div class="row-fluid">
				<div class="row-title">
				<?php echo $results['district']['title'].' дүүргийн зурган тэмдэглэгээны талаар мэдээлэл'; ?>
				</div>
				<div class="clearfix"></div>
		</div>
			<?php
				$k = 0;
				foreach($results['count'] as $result) : 
				$k = $k + 1;
				if($k == 1){
					echo '<div class="row-fluid row-admin">';
				}
			?>
				<div class="quick-button metro span2 info-box2">
					<img src="<?php echo $result['image']; ?>"/>
					<div class="info-block-desc">
						<?php echo $result['type'] ?>
					</div>
					<div class="info-block-info">
						<?php echo $result['COUNT(*)']; ?>
					</div>
				</div>
			<?php
				if($k == 6){
					echo '</div>';
					$k = 0;
				}
				endforeach; 
			?>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>