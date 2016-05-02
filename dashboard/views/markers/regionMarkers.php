<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<style>
	@page { 
        size: landscape;
    }
</style>

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
	<div class="box span11 markerBox">
		<div class="box-header markerBoxTitle" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>Зурган тэмдэглэгээ /<?php echo $results['district']['title'].' дүүргийн '.$results['region']['title'].'-р хороо'; ?>/</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<video width="300" height="147" controls>
  				<source src="<?php echo MAIN_FOLDER.'/video/khoroo/zurag.mp4'; ?>" type="video/mp4">
  				<source src="<?php echo MAIN_FOLDER.'/video/khoroo/zurag.ogg'; ?>" type="video/ogg">
  				Your browser does not support HTML5 video.
		</video>
		<div class="box-content markerBtn">
			<a href="?action=select" class='quick-button-small span2'><i class="icon-map-marker"></i><p>Зурган тэмдэглэгээ нэмэх</p></a>
			<a href="?action=delselect" class='quick-button-small span2'><i class="icon-trash"></i><p>Зурган тэмдэглэгээ устгах</p></a>
			<div class="clearfix"></div>
		</div>
		<div class="printBtnRow2" style="margin-left: 15px; margin-top: 15px;">
			<a href="javascript:window.print()" class="printBtn2"><i class="icon-print"></i> Хэвлэх</a>
		</div>
		<div class="box-content">
			<div class="row-fluid">
				<div class="row-title">
				<?php echo $results['district']['title'].' дүүргийн '.$results['region']['title'].'-р хорооны зурган тэмдэглэгээны талаар мэдээлэл'; ?>
				</div>
				<div class="clearfix"></div>
		</div>
			<?php
				$k = 0;
				foreach($results['count'] as $result) : 
				$k = $k + 1;
				if($k == 1){
					echo '<div class="row-fluid row-admin2">';
				}
			?>
			
				<div class="quick-button metro span2 info-box2">
					<a class="quick-button-link" href="markers.php?action=regionAdd&type=<?php echo $result['num']; ?>">
						<img src="<?php echo $result['image']; ?>"/>
						<div class="info-block-desc">
							<?php echo $result['type'] ?>
						</div>
						<div class="info-block-info">
							<?php echo $result['COUNT(*)']; ?>
						</div>
					</a>
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