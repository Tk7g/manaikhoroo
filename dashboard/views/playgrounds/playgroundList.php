<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/playground.php">Ногоон байгууламж болох боломжит газар /<?php echo $districtHeader['title'].' дүүргийн '.$regionHeader['title'].'-р хороо'; ?>/</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>Ногоон байгууламжийн жагсаалт /<?php echo $districtHeader['title'].' дүүргийн '.$regionHeader['title'].'-р хороо'; ?>/</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<video width="300" height="147" controls>
  				<source src="<?php echo MAIN_FOLDER.'/video/khoroo/nogoon.mp4'; ?>" type="video/mp4">
  				<source src="<?php echo MAIN_FOLDER.'/video/khoroo/nogoon.ogg'; ?>" type="video/ogg">
  				Your browser does not support HTML5 video.
			</video>
		</div>
		<div class="box-content">
			<a href="?action=draw" class='quick-button-small span1'><i class="icon-plus"></i><p>Нэмэх</p></a>
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
						<th width="25%">Ногоон байгууламжийн нэр, байршил</th>
						<th width="25%"></th>
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