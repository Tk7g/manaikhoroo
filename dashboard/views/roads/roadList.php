<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/road.php">Газрын зураглал /<?php echo $districtHeader['title'].' дүүргийн '.$regionHeader['title'].'-р хороо'; ?>/</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>Замын зураглалын жагсаалт /<?php echo $districtHeader['title'].' дүүргийн '.$regionHeader['title'].'-р хороо'; ?>/</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
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
						<th width="7%">№</th>
						<th width="18%">Дүүрэг</th>
						<th width="10%">Хороо</th>
						<th width="10%">Он</th>
						<th width="25%">Замын нэр, тайлбар</th>
						<th width="25%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($data as $road) :
						$k = $k + 1; 
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $road['districtTitle']; ?></td>
						<td><?php echo $road['regionTitle'].'-р хороо'; ?></td>
						<td><?php echo $road['year']; ?></td>
						<td><?php echo $road['title']; ?></td>
						<td>
							<a href="?action=delete&id=<?php echo $road['id']; ?>" class='btn btn-success'><i class="halflings-icon white edit"></i> Устгах</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>