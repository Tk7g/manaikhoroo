<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/section.php">Хэсгийн хил</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>Хэсгийн хилийн жагсаалт <?php if($_SESSION['login']['group_id'] == 3){ echo '/'.$districtHeader['title'].' дүүргийн '.$regionHeader['title'].'-р хороо/'; } ?></h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php if($_SESSION['login']['group_id'] == 3) { ?>
			<video width="300" height="147" controls>
  				<source src="<?php echo MAIN_FOLDER.'/video/khoroo/hesgiin_hil.mp4'; ?>" type="video/mp4">
  				<source src="<?php echo MAIN_FOLDER.'/video/khoroo/hesgiin_hil.ogg'; ?>" type="video/ogg">
  				Your browser does not support HTML5 video.
			</video>
			<?php } ?>
		</div>
		<div class="box-content">
			<?php if($_SESSION['login']['group_id'] == 3) { ?>
				<a href="?action=draw&district=<?php echo $_SESSION['login']['district_id']; ?>&region=<?php echo $_SESSION['login']['region_id']; ?>" class='quick-button-small span1'><i class="icon-plus"></i><p>Нэмэх</p></a>
			<?php } else { ?>
				<a href="?action=add" class='quick-button-small span1'><i class="icon-plus"></i><p>Нэмэх</p></a>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
		<?php if ( isset( $results['statusMessage'] ) ) { ?>
        	<div class="box-content status-message"><?php echo $results['statusMessage'] ?></div>
		<?php } ?>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th width="10%">№</th>
						<th width="20%">Дүүрэг</th>
						<th width="20%">Хороо</th>
						<th width="20%">Хэсгийн тоо</th>
						<th width="15%">Баталгаажсан эсэх</th>
						<th width="15%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($data as $section) :
						$k = $k + 1; 
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $section['districtTitle']; ?></td>
						<td><?php echo $section['regionTitle'].'-р хороо'; ?></td>
						<td><?php echo $section['title']; ?></td>
						<td>
						<?php
							if($section['published'] == 1) {
								echo '<i class="halflings-icon ok"></i>';
							} else {
								echo '<i class="halflings-icon remove"></i>';
							}
						?>
						</td>
						<td>
							<a href="?action=delete&id=<?php echo $section['id']; ?>" class='btn btn-success'><i class="halflings-icon white edit"></i> Устгах</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>