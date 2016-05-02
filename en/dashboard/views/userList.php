<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include("session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/users.php">Хэрэглэгчийн жагсаалт</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>Хэрэглэгчдийн жагсаалт</h2>
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
						<th>Хэрэглэгчийн нэр</th>
						<th>Хэрэглэгчийн бүлэг</th>
						<th>Дүүрэг</th>
						<th>Хороо</th>
						<th>Үүсгэсэн</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($data as $user) :
						$k = $k + 1; 
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $user['username']; ?></td>
						<td><?php echo $user['group_id']; ?></td>
						<td><?php echo $user['district']; ?></td>
						<td>
						<?php
							if($user['region'] != NULL) {
								echo $user['region'].'-р хороо'; 	
							} 
						?>
						</td>
						<td><?php echo $user['created']; ?></td>
						<td>
							<a href="?action=edit&id=<?php echo $user['id']; ?>" class='btn btn-success'><i class="halflings-icon white edit"></i> Засварлах</a>
							<a href="?action=delete&id=<?php echo $user['id']; ?>" class='btn btn-danger' onclick="return confirm('<?php echo $user['username']; ?> нэртэй хэрэглэгчийг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>