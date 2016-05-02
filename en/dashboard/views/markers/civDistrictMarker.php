<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php?action=civRegionMarker">Зурган тэмдэглэгээний жагсаалт</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>Иргэдээс ирүүлсэн зурган тэмдэглэгээний жагсаалт</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<?php if ( isset( $results['statusMessage'] ) ) { ?>
        	<div class="box-content status-message"><?php echo $results['statusMessage'] ?></div>
		<?php } ?>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th>№</th>
						<th>Төрөл</th>
						<th>Дүүрэг</th>
						<th>Хороо</th>
						<th>Хэнээс</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($markers as $marker) :
						$k = $k + 1; 
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $marker['typeTitle']; ?></td>
						<td><?php echo $marker['districtTitle']; ?></td>
						<td><?php echo $marker['regionTitle'].'-р хороо'; ?></td>
						<td>
							<div><span>Нэр: </span><?php echo substr($marker['lastname'],0,2).'.'.$marker['firstname']; ?></div>
							<div><span>Регистр №</span><?php echo $marker['identity']; ?></div>
							<div><span>И-мэйл</span><?php echo $marker['email']; ?></div>
							<div><span>Утас</span><?php echo $marker['phone']; ?></div>
						</td>
						<td>
							<?php if($_GET['action'] == 'civDistrictMarkerAccepted') { ?>
							<a href="?action=civDistrictMarkerDecline&marker=<?php echo $marker['id']; ?>" class='btn btn-success'><i class="halflings-icon white edit"></i> Дэлгэрэнгүй</a>
							<?php } else { ?>
							<a href="?action=civDistrictMarkerAccept&marker=<?php echo $marker['id']; ?>" class='btn btn-success'><i class="halflings-icon white edit"></i> Дэлгэрэнгүй</a>
							<?php } ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>