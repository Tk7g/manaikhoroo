<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/sanal.php">Санал хүсэлтийн жагсаалт</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo $district['title'].' дүүргийн '.$region['title'].'-р хороонд ирсэн'; ?> хариу өгсөн санал хүсэлтийн жагсаалт</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<?php if ( isset( $result ) ) { ?>
        	<div class="box-content status-message"><?php echo $result; ?></div>
			<?php } ?>
			<table width="100%" class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th>№</th>
						<th width="10%">Ангилал</th>
						<th width="30%">Бичсэн</th>
						<th>Агуулга</th>
						<th width="15%">Үүсгэсэн</th>
						<th width="15%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($results as $sanal) :
						$k = $k + 1; 
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $sanal['type']; ?></td>
						<td>
							<div>Нэр: <?php echo substr($sanal['lastname'], 0, 2).'.'.$sanal['firstname']; ?></div>
							<div>Регистрийн №: <?php echo $sanal['identity']; ?></div>
							<div>Утас: <?php echo $sanal['phone']; ?></div>
						</td>
						<td><?php echo substr($sanal['content'], 0, 200); ?></td>
						<td><?php echo $sanal['created']; ?></td>
						<td>
							<a href="?action=repliedRegion&id=<?php echo $sanal['id']; ?>" class='btn btn-success'><i class="halflings-icon white edit"></i> Дэлгэрэнгүй</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>