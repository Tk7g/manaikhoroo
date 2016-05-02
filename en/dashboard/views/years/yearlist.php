<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/year.php">Оны жагсаалт</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>Оны жагсаалт</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<a href="?action=add" class='quick-button-small span1'><i class="icon-plus"></i><p>Нэмэх</p></a>
			<div class="clearfix"></div>
		</div>
		<?php if ( isset( $results['statusMessage'] ) ) { ?>
        	<div class="box-content status-message"><?php echo $results['statusMessage'] ?></div>
		<?php } ?>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th>№</th>
						<th>Он</th>
						<th>Үндсэн</th>
						<th>Үүсгэсэн</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($data as $yr) :
						$k = $k + 1; 
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $yr['year']; ?></td>
						<td class="text-center">
						<?php 
							if($yr['used'] == 1) {
								echo '<i class="halflings-icon ok"></i>';
							} else {
								echo '<i class="halflings-icon remove"></i>';
							} 
						?>
						</td>
						<td><?php echo $yr['created']; ?></td>
						<td>
							<a href="?action=edit&id=<?php echo $yr['id']; ?>" class='btn btn-success'><i class="halflings-icon white edit"></i> Засварлах</a>
							<a href="?action=delete&id=<?php echo $yr['id']; ?>" class='btn btn-danger' onclick="return confirm('<?php echo $yr['year']; ?> оныг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>