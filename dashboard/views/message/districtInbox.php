<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/message.php?action=districtInbox">Ирсэн мессеж</a>
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
		<?php if ( isset( $results['statusMessage'] ) ) { ?>
        	<div class="box-content status-message"><?php echo $results['statusMessage'] ?></div>
		<?php } ?>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
				<thead>
					<tr>
						<th width="5%">№</th>
						<th width="65%">Мессеж</th>
						<th width="15%">Илгээсэн</th>
						<th width="15%">Илгээсэн огноо</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$k = 0; 
						foreach($inbox_messages as $msg) :
						$k = $k + 1;
						$message = Message::getMessage($msg['message_id']);
					?>
					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $message['text']; ?></td>
						<td><?php echo getUser($message['wrote']); ?></td>
						<td><?php echo $message['created']; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>