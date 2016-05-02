<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=regionList">Мессеж</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo 'Мессеж'; ?></h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<a href="?action=regionWrite" class='quick-button-small span1'><i class="icon-plus"></i><p>Шинэ</p></a>
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
						<th>Мессеж</th>
						<th>Илгээсэн огноо</th>
						<th>Хариу</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($messages as $msg) :
						$k = $k + 1; 
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $msg['text']; ?></td>
						<td><?php echo $msg['created']; ?></td>
						<td><?php echo $msg['reply']; ?></td>
						<td>
							<a href="?action=deleteRegion&id=<?php echo $msg['id']; ?>" class='btn btn-danger' onclick="return confirm('<?php echo $msg['text']; ?> - мессежийг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>